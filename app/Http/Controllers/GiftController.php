<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\GiftAddon;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::where('is_active', true)
            ->orderBy('sort_order')
            ->with('addons')
            ->get();
        
        return view('gifts.index', compact('gifts'));
    }

    public function show($id)
    {
        $gift = Gift::findOrFail($id);
        
        if (!$gift->is_active) {
            abort(404);
        }
        
        // Get all other active gifts as addons (excluding the current gift)
        $availableGifts = Gift::where('is_active', true)
            ->where('id', '!=', $gift->id)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        return view('gifts.show', compact('gift', 'availableGifts'));
    }

    public function customize($id)
    {
        $gift = Gift::findOrFail($id);
        
        if (!$gift->is_active) {
            abort(404);
        }
        
        // Get all other active gifts as addons (excluding the current gift)
        $availableGifts = Gift::where('is_active', true)
            ->where('id', '!=', $gift->id)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('gifts.customize', compact('gift', 'availableGifts'));
    }

    public function quickBuy($id)
    {
        $gift = Gift::with('addons')->findOrFail($id);
        
        if (!$gift->is_active) {
            abort(404);
        }

        // Quick buy - no addons, just the gift - send directly to WhatsApp
        $whatsappUrl = $this->buildWhatsAppUrl($gift, collect([]));
        return redirect($whatsappUrl);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|exists:gifts,id',
            'selected_addons' => 'nullable|array',
            'selected_addons.*' => 'exists:gifts,id',
        ]);

        $gift = Gift::findOrFail($request->gift_id);
        $selectedAddonIds = $request->selected_addons ?? [];
        // Get selected gifts as addons (excluding the main gift)
        $selectedAddons = Gift::whereIn('id', $selectedAddonIds)
            ->where('id', '!=', $gift->id)
            ->get();

        // Build WhatsApp message directly
        $whatsappUrl = $this->buildWhatsAppUrl($gift, $selectedAddons);
        
        // Redirect directly to WhatsApp
        return redirect($whatsappUrl);
    }

    private function buildWhatsAppUrl($gift, $selectedAddons)
    {
        // WhatsApp Business API number (replace with your actual number)
        $whatsappNumber = env('WHATSAPP_NUMBER', '9779845004365'); // Format: country code + number without +
        
        // Build message
        $message = "🎁 *Gift Order Request*\n\n";
        $message .= "*Gift:* " . $gift->name . "\n";
        $message .= "*Gift Price:* Rs. " . number_format($gift->price, 2) . "\n\n";
        
        if ($selectedAddons->count() > 0) {
            $message .= "*Selected Addons:*\n";
            foreach ($selectedAddons as $addon) {
                $message .= "• " . $addon->name . " - Rs. " . number_format($addon->price, 2) . "\n";
            }
            $message .= "\n";
            
            $subtotal = $gift->price + $selectedAddons->sum('price');
            $discountPercentage = Setting::getDiscountPercentage();
            $discount = $subtotal * ($discountPercentage / 100);
            $message .= "*Subtotal:* Rs. " . number_format($subtotal, 2) . "\n";
            $message .= "*Discount ({$discountPercentage}%):* -Rs. " . number_format($discount, 2) . "\n";
            $message .= "\n";
            
            $totalAmount = $subtotal - $discount;
        } else {
            $totalAmount = $gift->price;
        }
        
        $message .= "*Total Amount:* Rs. " . number_format($totalAmount, 2) . "\n\n";
        $message .= "Please provide your details:\n";
        $message .= "• Full Name\n";
        $message .= "• Email\n";
        $message .= "• Phone Number\n";
        $message .= "• Delivery Address\n";
        $message .= "• Any special notes\n\n";
        $message .= "Thank you for choosing us! 🙏";
        
        // URL encode the message
        $encodedMessage = urlencode($message);
        
        // Create WhatsApp URL
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
        
        return $whatsappUrl;
    }

    public function submitOrder(Request $request)
    {
        $request->validate([
            'gift_id' => 'required|exists:gifts,id',
            'selected_addons' => 'nullable|array',
            'selected_addons.*' => 'exists:gifts,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $gift = Gift::findOrFail($request->gift_id);
        $selectedAddonIds = $request->selected_addons ?? [];
        // Get selected gifts as addons (excluding the main gift)
        $selectedAddons = Gift::whereIn('id', $selectedAddonIds)
            ->where('id', '!=', $gift->id)
            ->get();

        $addonsTotal = $selectedAddons->sum('price');
        $subtotal = $gift->price + $addonsTotal;
        
        // Apply discount for customization (only if addons are selected)
        $discount = 0;
        if ($selectedAddons->count() > 0) {
            $discountPercentage = Setting::getDiscountPercentage();
            $discount = $subtotal * ($discountPercentage / 100);
        }
        $totalAmount = $subtotal - $discount;

        $order = Order::create([
            'user_id' => Auth::id(),
            'gift_id' => $gift->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'gift_price' => $gift->price,
            'addons_total' => $addonsTotal,
            'total_amount' => $totalAmount,
            'selected_addons' => $selectedAddonIds,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        // Send WhatsApp message
        $this->sendWhatsAppMessage($order, $gift, $selectedAddons);

        return redirect()->route('gifts.order-success', $order->id)
            ->with('success', 'Order placed successfully! We will contact you soon.');
    }

    public function orderSuccess($id)
    {
        $order = Order::with('gift')->findOrFail($id);
        return view('gifts.order-success', compact('order'));
    }

    private function sendWhatsAppMessage($order, $gift, $selectedAddons)
    {
        // WhatsApp Business API number (replace with your actual number)
        $whatsappNumber = env('WHATSAPP_NUMBER', '9779845004365'); // Format: country code + number without +
        
        // Build message
        $message = "🎁 *New Gift Order Received!*\n\n";
        $message .= "*Order Number:* " . $order->order_number . "\n";
        $message .= "*Gift:* " . $gift->name . "\n";
        $message .= "*Gift Price:* Rs. " . number_format($gift->price, 2) . "\n\n";
        
        if ($selectedAddons->count() > 0) {
            $message .= "*Selected Addons:*\n";
            foreach ($selectedAddons as $addon) {
                $message .= "• " . $addon->name . " - Rs. " . number_format($addon->price, 2) . "\n";
            }
            $message .= "\n";
            
            $subtotal = $gift->price + $selectedAddons->sum('price');
            $discountPercentage = Setting::getDiscountPercentage();
            $discount = $subtotal * ($discountPercentage / 100);
            $message .= "*Subtotal:* Rs. " . number_format($subtotal, 2) . "\n";
            $message .= "*Discount ({$discountPercentage}%):* -Rs. " . number_format($discount, 2) . "\n";
            $message .= "\n";
        }
        
        $message .= "*Total Amount:* Rs. " . number_format($order->total_amount, 2) . "\n\n";
        $message .= "*Customer Details:*\n";
        $message .= "Name: " . $order->customer_name . "\n";
        $message .= "Email: " . $order->customer_email . "\n";
        $message .= "Phone: " . $order->customer_phone . "\n";
        
        if ($order->customer_address) {
            $message .= "Address: " . $order->customer_address . "\n";
        }
        
        if ($order->notes) {
            $message .= "\n*Notes:* " . $order->notes . "\n";
        }
        
        // URL encode the message
        $encodedMessage = urlencode($message);
        
        // Create WhatsApp link
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
        
        // In a real application, you might want to use a WhatsApp API service
        // For now, we'll log it and the frontend can open the link
        \Log::info('WhatsApp message prepared', [
            'order_id' => $order->id,
            'whatsapp_url' => $whatsappUrl
        ]);
        
        // Store WhatsApp URL in session for frontend to use
        session(['whatsapp_url' => $whatsappUrl]);
        
        return $whatsappUrl;
    }
}

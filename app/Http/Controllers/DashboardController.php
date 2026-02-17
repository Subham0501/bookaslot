<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\BusinessBanner;
use App\Models\BusinessAnalytic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DashboardController extends Controller
{
    private function compressAndUpload($file, $path_prefix, $width = 800, $quality = 75)
    {
        try {
            // Check if file is small enough to skip compression (e.g., < 200KB)
            if ($file->getSize() < 200 * 1024) {
               $path = $file->store($path_prefix, 'cloudflare');
               return $path;
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            
            // Only scale down if image is larger than target width
            $image->scaleDown(width: $width);
            
            // Encode to WebP for significant file size reduction
            $encoded = $image->toWebp($quality);
            
            $filename = Str::random(40) . '.webp';
            $path = $path_prefix . '/' . $filename;
            
            Storage::disk('cloudflare')->put($path, (string) $encoded);
            
            return $path;
        } catch (\Exception $e) {
            // Fallback to original file if compression fails
            \Log::error('Image compression failed: ' . $e->getMessage());
            return $file->store($path_prefix, 'cloudflare');
        }
    }

    public function index()
    {
        $user = Auth::user();
        $business = $user->business;

        if (!$business) {
            return view('dashboard.no_business');
        }

        $analytics = [
            'total_scans' => $business->analytics()->where('type', 'scan')->count(),
            'product_views' => $business->analytics()->where('type', 'product_view')->count(),
            'whatsapp_clicks' => $business->analytics()->where('type', 'whatsapp_click')->count(),
            'popular_products' => $business->products()->orderBy('id', 'desc')->take(5)->get(),
        ];

        return view('dashboard.index', compact('business', 'analytics'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $business = $user->business;

        // Only admin can create business for others, 
        // normal user can only update their own business if it exists
        if (!$business) {
            return abort(403, 'Normal users cannot create businesses. Please contact admin.');
        }

        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:businesses,slug,' . $business->id,
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'google_maps_link' => 'nullable|url',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'whatsapp_number' => 'nullable|string',
            'footer_about' => 'nullable|string',
            'copyright_text' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'logo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            if ($business->logo) {
                if (Str::startsWith($business->logo, 'http')) {
                    $path = parse_url($business->logo, PHP_URL_PATH);
                    // Remove leading slash if present
                    $path = ltrim($path, '/'); 
                    Storage::disk('cloudflare')->delete($path);
                } else {
                    Storage::disk('public')->delete($business->logo);
                }
            }
            $path = $this->compressAndUpload($request->file('logo'), 'logos', 400, 80);
            $data['logo'] = Storage::disk('cloudflare')->url($path);
        }

        // Handle Social Links
        $socialLinks = $business->social_links ?? [];
        if ($request->has('facebook_link')) $socialLinks['facebook'] = $request->input('facebook_link');
        if ($request->has('tiktok_link')) $socialLinks['tiktok'] = $request->input('tiktok_link');
        if ($request->has('instagram_link')) $socialLinks['instagram'] = $request->input('instagram_link');
        $data['social_links'] = $socialLinks;

        $business->update($data);

        return redirect()->route('dashboard.index')->with('success', 'Profile updated successfully!');
    }

    public function products()
    {
        $business = Auth::user()->business;
        if (!$business) return redirect()->route('dashboard.index');
        
        $categories = $business->categories;
        $products = $business->products()->with('category')->get();
        return view('dashboard.products', compact('business', 'categories', 'products'));
    }

    public function storeProduct(Request $request)
    {
        $business = Auth::user()->business;
        $data = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $data['business_id'] = $business->id;
        $data['slug'] = Str::slug($data['name']) . '-' . rand(100, 999);
        
        if ($request->hasFile('image')) {
            $path = $this->compressAndUpload($request->file('image'), 'products', 800, 75);
            $data['image'] = Storage::disk('cloudflare')->url($path);
        }

        Product::create($data); // Create the product using the Product model directly
        return back()->with('success', 'Product added successfully!');
    }

    public function updateProduct(Request $request, $id)
    {
        $business = Auth::user()->business;
        $product = $business->products()->findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'is_in_stock' => 'boolean',
            'image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                if (Str::startsWith($product->image, 'http')) {
                    $path = parse_url($product->image, PHP_URL_PATH);
                    $path = ltrim($path, '/');
                    Storage::disk('cloudflare')->delete($path);
                } else {
                    Storage::disk('public')->delete($product->image);
                }
            }
            $path = $this->compressAndUpload($request->file('image'), 'products', 800, 75);
            $data['image'] = Storage::disk('cloudflare')->url($path);
        }

        $product->update($data);
        return back()->with('success', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $business = Auth::user()->business;
        $product = $business->products()->findOrFail($id);
        
        if ($product->image) {
            if (Str::startsWith($product->image, 'http')) {
                $path = parse_url($product->image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('cloudflare')->delete($path);
            } else {
                Storage::disk('public')->delete($product->image);
            }
        }
        
        $product->delete();
        return back()->with('success', 'Product deleted successfully!');
    }

    public function storeCategory(Request $request)
    {
        $business = Auth::user()->business;
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['business_id'] = $business->id;
        $data['slug'] = Str::slug($data['name']);

        ProductCategory::create($data);
        return back()->with('success', 'Category created successfully!');
    }

    public function banners()
    {
        $business = Auth::user()->business;
        if (!$business) return redirect()->route('dashboard.index');
        
        $banners = $business->banners;
        return view('dashboard.banners', compact('business', 'banners'));
    }

    public function storeBanner(Request $request)
    {
        $business = Auth::user()->business;
        $data = $request->validate([
            'title' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'description' => 'nullable|string',
        ]);

        $data['business_id'] = $business->id;
        $path = $this->compressAndUpload($request->file('image'), 'banners', 1200, 80);
        $data['image'] = Storage::disk('cloudflare')->url($path);

        BusinessBanner::create($data);
        return back()->with('success', 'Banner added successfully!');
    }

    public function destroyBanner($id)
    {
        $business = Auth::user()->business;
        $banner = $business->banners()->findOrFail($id);
        
        if ($banner->image) {
            if (Str::startsWith($banner->image, 'http')) {
                $path = parse_url($banner->image, PHP_URL_PATH);
                $path = ltrim($path, '/');
                Storage::disk('cloudflare')->delete($path);
            } else {
                Storage::disk('public')->delete($banner->image);
            }
        }
        
        $banner->delete();
        return back()->with('success', 'Banner deleted successfully!');
    }
}

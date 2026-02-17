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

class DashboardController extends Controller
{
    private function compressAndUpload($file, $path_prefix, $maxWidth = 1200, $quality = 75)
    {
        try {
            if (!$file->isValid()) {
                \Log::error('Upload file is invalid: ' . $file->getErrorMessage());
                return $file->store($path_prefix, 'cloudflare');
            }

            $realPath = $file->getRealPath();
            $imageData = file_get_contents($realPath);
            $origSize = strlen($imageData);
            $extension = strtolower($file->getClientOriginalExtension());
            if ($extension === 'jpeg') $extension = 'jpg';
            
            // Skip if GD extension is not available
            if (function_exists('imagecreatefromstring')) {
                $img = @imagecreatefromstring($imageData);
                if ($img) {
                    $width = imagesx($img);
                    $height = imagesy($img);
                    $maxDim = $maxWidth;

                    // Resize if needed - Match CustomizedTemplateController logic exactly
                    if ($width > $maxDim || $height > $maxDim) {
                        if ($width > $height) {
                            $newWidth = $maxDim;
                            $newHeight = (int)($height * ($maxDim / $width));
                        } else {
                            $newHeight = $maxDim;
                            $newWidth = (int)($width * ($maxDim / $height));
                        }
                        
                        $tmp = imagecreatetruecolor($newWidth, $newHeight);
                        if ($extension === 'png') {
                            imagealphablending($tmp, false);
                            imagesavealpha($tmp, true);
                        }
                        
                        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagedestroy($img);
                        $img = $tmp;
                    }

                    ob_start();
                    if ($extension === 'png') {
                        imagepng($img, null, 7);
                    } else {
                        imagejpeg($img, null, $quality);
                    }
                    $optimizedData = ob_get_clean();
                    imagedestroy($img);

                    if ($optimizedData && strlen($optimizedData) < strlen($imageData)) {
                        $imageData = $optimizedData;
                        \Log::info('Image optimized', [
                            'orig_size' => round($origSize / 1024, 2) . 'KB',
                            'new_size' => round(strlen($imageData) / 1024, 2) . 'KB'
                        ]);
                    }
                }
            }
            
            $filename = Str::random(40) . '.' . $extension;
            $path = $path_prefix . '/' . $filename;
            
            Storage::disk('cloudflare')->put($path, $imageData, 'public');
            return $path;

        } catch (\Exception $e) {
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

        \Log::info('Profile update started', ['file_size' => $request->hasFile('logo') ? $request->file('logo')->getSize() : 'no file']);
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

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
            $path = $this->compressAndUpload($request->file('logo'), 'logos', 400, 75);
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
        \Log::info('Product store started', ['file_size' => $request->hasFile('image') ? $request->file('image')->getSize() : 'no file']);
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
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
        \Log::info('Product update started', ['id' => $id, 'file_size' => $request->hasFile('image') ? $request->file('image')->getSize() : 'no file']);
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
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
        \Log::info('Banner store started', ['file_size' => $request->hasFile('image') ? $request->file('image')->getSize() : 'no file']);
        ini_set('memory_limit', '1024M');
        set_time_limit(300);
        $business = Auth::user()->business;
        $data = $request->validate([
            'title' => 'nullable|string',
            'image' => 'required|image|max:5120',
            'description' => 'nullable|string',
        ]);

        $data['business_id'] = $business->id;
        $path = $this->compressAndUpload($request->file('image'), 'banners', 1200, 75);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Business;
use App\Models\BusinessAnalytic;

class ShowcaseController extends Controller
{
    public function show($slug)
    {
        $business = Business::where('slug', $slug)
            ->where('is_active', true)
            ->with(['categories', 'products', 'banners'])
            ->firstOrFail();

        // Record scan analytic only once per session
        $sessionKey = 'business_scanned_' . $business->id;
        if (!session()->has($sessionKey)) {
            BusinessAnalytic::create([
                'business_id' => $business->id,
                'type' => 'scan',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            session()->put($sessionKey, true);
        }

        // Record product views for all products on the page (once per session)
        $productViewKey = 'products_viewed_' . $business->id;
        if (!session()->has($productViewKey)) {
            foreach ($business->products as $product) {
                BusinessAnalytic::create([
                    'business_id' => $business->id,
                    'type' => 'product_view',
                    'model_id' => $product->id,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
            session()->put($productViewKey, true);
        }

        $theme = $business->category ?? 'default';
        if (!view()->exists('business.themes.' . $theme)) {
            $theme = 'default';
        }
        return view('business.themes.' . $theme, compact('business'));
    }

    public function trackAnalytic(Request $request, $businessId)
    {
        $type = $request->query('type');
        $target = $request->query('target');
        $modelId = $request->query('model_id');

        BusinessAnalytic::create([
            'business_id' => $businessId,
            'type' => $type,
            'model_id' => $modelId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect($target);
    }
}

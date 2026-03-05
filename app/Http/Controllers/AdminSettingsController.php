<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $discountSetting = Setting::where('key', 'gift_customization_discount')->first();
        $featuredBusinessSetting = Setting::where('key', 'home_featured_business_id')->first();
        $featuredBusinessEnabled = Setting::where('key', 'home_featured_business_enabled')->first();
        
        $businesses = \App\Models\Business::where('is_active', true)->orderBy('business_name')->get();

        // Convert stored JSON/Value to array
        $featuredIds = $featuredBusinessSetting && $featuredBusinessSetting->value ? json_decode($featuredBusinessSetting->value, true) : [];
        if (!is_array($featuredIds)) {
            $featuredIds = $featuredBusinessSetting && $featuredBusinessSetting->value ? [$featuredBusinessSetting->value] : [];
        }

        return view('admin.settings.index', [
            'discount' => $discountSetting ? (float) $discountSetting->value : 5,
            'discountDescription' => $discountSetting ? $discountSetting->description : 'Discount percentage for gift customization',
            'featuredBusinessIds' => $featuredIds,
            'featuredBusinessEnabled' => $featuredBusinessEnabled ? (bool) $featuredBusinessEnabled->value : false,
            'businesses' => $businesses,
        ]);
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'gift_customization_discount' => 'required|numeric|min:0|max:100',
            'home_featured_business_ids' => 'nullable|array',
            'home_featured_business_ids.*' => 'exists:businesses,id',
            'home_featured_business_enabled' => 'nullable|boolean',
        ]);

        Setting::set(
            'gift_customization_discount',
            $request->gift_customization_discount,
            'number',
            'Discount percentage for gift customization (when addons are selected)'
        );

        Setting::set(
            'home_featured_business_id',
            json_encode($request->home_featured_business_ids ?? []),
            'json',
            'JSON array of businesses to feature on the home page'
        );

        Setting::set(
            'home_featured_business_enabled',
            $request->has('home_featured_business_enabled') ? '1' : '0',
            'boolean',
            'Enable or disable featured business on the home page'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}

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
        
        return view('admin.settings.index', [
            'discount' => $discountSetting ? (float) $discountSetting->value : 5,
            'discountDescription' => $discountSetting ? $discountSetting->description : 'Discount percentage for gift customization',
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
        ]);

        Setting::set(
            'gift_customization_discount',
            $request->gift_customization_discount,
            'number',
            'Discount percentage for gift customization (when addons are selected)'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}

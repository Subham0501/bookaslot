<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\GiftAddon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminGiftController extends Controller
{
    /**
     * Display a listing of gifts.
     */
    public function index()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $gifts = Gift::with('addons')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        return view('admin.gifts.index', compact('gifts'));
    }

    /**
     * Show the form for creating a new gift.
     */
    public function create()
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.gifts.create');
    }

    /**
     * Store a newly created gift.
     */
    public function store(Request $request)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $gift = new Gift();
        $gift->name = $request->name;
        $gift->description = $request->description;
        $gift->price = $request->price;
        $gift->is_active = $request->has('is_active') ? true : false;
        $gift->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $gift->image = $request->file('image')->store('gifts', 'public');
        }

        $gift->save();

        return redirect()->route('admin.gifts.index')
            ->with('success', 'Gift created successfully!');
    }

    /**
     * Show the form for editing the specified gift.
     */
    public function edit($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $gift = Gift::with('addons')->findOrFail($id);
        return view('admin.gifts.edit', compact('gift'));
    }

    /**
     * Update the specified gift.
     */
    public function update(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $gift = Gift::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $gift->name = $request->name;
        $gift->description = $request->description;
        $gift->price = $request->price;
        $gift->is_active = $request->has('is_active') ? true : false;
        $gift->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gift->image) {
                Storage::disk('public')->delete($gift->image);
            }
            $gift->image = $request->file('image')->store('gifts', 'public');
        }

        $gift->save();

        return redirect()->route('admin.gifts.index')
            ->with('success', 'Gift updated successfully!');
    }

    /**
     * Remove the specified gift.
     */
    public function destroy($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $gift = Gift::findOrFail($id);

        // Delete image if exists
        if ($gift->image) {
            Storage::disk('public')->delete($gift->image);
        }

        $gift->delete();

        return redirect()->route('admin.gifts.index')
            ->with('success', 'Gift deleted successfully!');
    }

    /**
     * Show addons for a specific gift.
     */
    public function showAddons($id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $gift = Gift::with('addons')->findOrFail($id);
        return view('admin.gifts.addons', compact('gift'));
    }

    /**
     * Store a new addon for a gift.
     */
    public function storeAddon(Request $request, $id)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $gift = Gift::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $addon = new GiftAddon();
        $addon->gift_id = $gift->id;
        $addon->name = $request->name;
        $addon->description = $request->description;
        $addon->price = $request->price;
        $addon->is_active = $request->has('is_active') ? true : false;
        $addon->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            $addon->image = $request->file('image')->store('gift-addons', 'public');
        }

        $addon->save();

        return redirect()->route('admin.gifts.addons', $gift->id)
            ->with('success', 'Addon created successfully!');
    }

    /**
     * Update an addon.
     */
    public function updateAddon(Request $request, $giftId, $addonId)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $addon = GiftAddon::where('gift_id', $giftId)->findOrFail($addonId);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $addon->name = $request->name;
        $addon->description = $request->description;
        $addon->price = $request->price;
        $addon->is_active = $request->has('is_active') ? true : false;
        $addon->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($addon->image) {
                Storage::disk('public')->delete($addon->image);
            }
            $addon->image = $request->file('image')->store('gift-addons', 'public');
        }

        $addon->save();

        return redirect()->route('admin.gifts.addons', $giftId)
            ->with('success', 'Addon updated successfully!');
    }

    /**
     * Delete an addon.
     */
    public function destroyAddon($giftId, $addonId)
    {
        // Check if user is admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }

        $addon = GiftAddon::where('gift_id', $giftId)->findOrFail($addonId);

        // Delete image if exists
        if ($addon->image) {
            Storage::disk('public')->delete($addon->image);
        }

        $addon->delete();

        return redirect()->route('admin.gifts.addons', $giftId)
            ->with('success', 'Addon deleted successfully!');
    }
}

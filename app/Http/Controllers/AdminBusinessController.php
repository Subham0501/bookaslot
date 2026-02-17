<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminBusinessController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized access');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $businesses = Business::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.businesses.index', compact('businesses'));
    }

    public function create()
    {
        $this->checkAdmin();
        return view('admin.businesses.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'business_name' => 'required|string|max:255',
            'category' => 'required|string|in:personal,travel,ecommerce,consultancy,hotels,photo',
            'slug' => 'required|string|unique:businesses,slug',
        ]);

        // 1. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto-verify for admin-created users
        ]);

        // 2. Create Business
        Business::create([
            'user_id' => $user->id,
            'business_name' => $request->business_name,
            'category' => $request->category,
            'slug' => Str::slug($request->slug),
            'is_active' => true,
            'plan' => 'basic',
        ]);

        return redirect()->route('admin.businesses.index')->with('success', 'Business user created successfully!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        $business = Business::findOrFail($id);
        $user = $business->user;
        
        $business->delete();
        if ($user) {
            $user->delete();
        }

        return back()->with('success', 'Business and user deleted successfully!');
    }
}

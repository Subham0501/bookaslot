<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        // Don't auto-login, require email verification first
        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account before logging in.');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm(Request $request)
    {
        // Store intended URL if coming from /create
        if ($request->has('intended') || $request->session()->has('intended')) {
            $intended = $request->get('intended', $request->session()->get('intended', '/create'));
            $request->session()->put('url.intended', $intended);
        }
        
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Please verify your email address before logging in. Check your inbox for the verification link.');
            }

            // Redirect admin users to admin panel
            if ($user && $user->is_admin) {
                // Clear any intended URL and redirect to admin panel
                $request->session()->forget('url.intended');
                return redirect('/admin/templates');
            }

            // Check if there's an intended URL, otherwise redirect to /create
            $intended = $request->session()->get('url.intended', '/create');
            $request->session()->forget('url.intended');
            
            // If intended was /create or login page, go to /create
            if ($intended === '/create' || $intended === route('login')) {
                return redirect('/create');
            }
            
            return redirect()->intended('/create');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Handle a logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}


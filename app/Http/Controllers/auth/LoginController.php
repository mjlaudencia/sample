<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
        
    }

 public function login(Request $request)
{
    // ✅ Validate input
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'min:6'],
    ], [
        'email.required' => 'Email is required.',
        'email.email' => 'Please provide a valid email address.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
    ]);

    // ✅ Attempt login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate(); // Prevent session fixation
        return redirect()->intended('/shop'); // Or your preferred route
    }

    // ❌ Failed login
    return back()->withErrors([
        'email' => 'The provided credentials are incorrect.',
    ])->onlyInput('email');
}


protected function authenticated(Request $request, $user)
{
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    } elseif ($user->role === 'delivery') {
        return redirect()->route('delivery.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
}
    
    public function redirectTo()
{
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => '/admin/dashboard',
        'vendor' => '/vendor/dashboard',
        'customer' => '/customer/dashboard',
        'delivery' => '/delivery/dashboard',
        default => '/',
    };
}
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
    

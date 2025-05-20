<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Show default (customer) registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Register as customer (default)
   public function register(Request $request)
{
   $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|string|min:6|confirmed',
    'address' => 'required|string|max:255',
    'contact_number' => 'required|string|max:20',
]);

    User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => $request->role ?? 'customer',
    'address' => $request->address,
    'contact_number' => $request->contact_number,
]);


    return redirect()->back()->with('success', 'User registered successfully!');
}

    // Show vendor registration form
    public function showVendorRegisterForm()
    {
        return view('auth.vendor-register');
    }

    // Register as vendor
    public function registerVendor(Request $request)
    {
       $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|string|min:6|confirmed',
    'address' => 'required|string|max:255',
    'contact_number' => 'required|string|max:20',
]);

        User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role' => $request->role ?? 'customer',
    'address' => $request->address,
    'contact_number' => $request->contact_number,
]);


        Auth::login($user);

        return redirect()->route('vendor.dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Required
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class VendorController extends Controller
{
    // Display the Vendor Dashboard
    public function dashboard()
    {
        $vendorId = auth()->id();
    
        // Count orders related to this vendor's products
        $orderCount = Order::whereHas('product', function ($query) use ($vendorId) {
            $query->where('user_id', $vendorId);
        })->count();
    
        // Count vendor's products
        $productCount = Product::where('user_id', $vendorId)->count();
    
        // Total sales (sum of total field from orders)
        $totalSales = Order::whereHas('product', function ($query) use ($vendorId) {
            $query->where('user_id', $vendorId);
        })->sum('total');
    
        return view('vendor.dashboard', compact('orderCount', 'productCount', 'totalSales'));
    }
    // Display all products for the vendor
 public function products()
{
    $vendorId = auth()->id();  // get logged-in vendor ID
    $products = Product::with('seller')->where('user_id', $vendorId)->get();
    return view('vendor.products', compact('products'));
}

    // Display vendor orders
    public function orders()
    {
        $vendor = Auth::user();
    
        $orders = Order::whereHas('product', function ($query) use ($vendor) {
            $query->where('user_id', $vendor->id);
        })->with(['product', 'user', 'deliveryPerson'])->latest()->get();
    
        $deliveryPeople = User::where('role', 'delivery')->get();
    
        return view('vendor.orders', compact('orders', 'deliveryPeople'));
    }

    // Vendor profile
    public function profile()
    {
        return view('vendor.profile');
    }

    public function updateOrderStatus(Request $request, Order $order)
{
    // Make sure the order belongs to the vendor
    if ($order->product->user_id !== auth()->id()) {
        abort(403); // Forbidden
    }

    $request->validate([
        'status' => 'required|in:pending,shipped,completed,cancelled',
    ]);

    $order->status = $request->status;
    $order->save();

    return redirect()->back()->with('success', 'Order status updated.');
}

public function updateOrder(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,processing,completed,cancelled',
        'delivery_status' => 'required|in:pending,out_for_delivery,delivered',
        'delivery_person_id' => 'nullable|exists:users,id',
    ]);

    $order->status = $request->status;
    $order->delivery_status = $request->delivery_status;
    $order->delivery_person_id = $request->delivery_person_id;
    $order->save();

    return redirect()->route('vendor.orders')->with('success', 'Order updated with delivery assignment.');
}

public function register(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'address' => 'nullable|string|max:255',
        'contact_number' => 'nullable|string|max:20',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'vendor',
        'address' => $validated['address'] ?? null,
        'contact_number' => $validated['contact_number'] ?? null,
    ]);

    Auth::login($user);

    return redirect()->route('vendor.dashboard')->with('success', 'Vendor registered successfully.');
}

}



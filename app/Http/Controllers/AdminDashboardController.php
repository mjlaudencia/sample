<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch data for vendors, customers, products, and orders
        $vendors = User::where('role', 'vendor')->count();
        $customers = User::where('role', 'customer')->count();
        $products = Product::count();
        $orders = Order::count();

        // Fetch recent orders with associated users (customers)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Fetch the latest vendors and products
        $vendorList = User::where('role', 'vendor')->latest()->take(5)->get();
        $productList = Product::latest()->take(5)->get();

        // Pass all fetched data to the view
        return view('admin.admin-dashboard', compact(
            'vendors',
            'customers',
            'products',
            'orders',
            'recentOrders',
            'vendorList',
            'productList'
        ));
    }
}

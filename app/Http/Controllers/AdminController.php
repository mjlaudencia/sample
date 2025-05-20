<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Rating;

class AdminController extends Controller
{
    public function dashboard()
    {
        $vendors = User::where('role', 'vendor')->count();
        $customers = User::where('role', 'customer')->count();
        $products = Product::count();
        $orders = Order::count();

        $recentOrders = Order::latest()->take(5)->get();
        $vendorList = User::where('role', 'vendor')->latest()->take(5)->get();
        $productList = Product::latest()->take(5)->get();

        $bestSellingProduct = Product::withCount('orders')
            ->orderByDesc('orders_count')
            ->first();

        $highestReviewedProduct = Product::withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->first();

        $highestReviewedSeller = User::where('role', 'vendor')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->first();

        return view('admin.dashboard', compact(
            'vendors',
            'customers',
            'products',
            'orders',
            'recentOrders',
            'vendorList',
            'productList',
            'bestSellingProduct',
            'highestReviewedProduct',
            'highestReviewedSeller'
        ));
    }

    public function viewVendors()
    {
        $vendors = User::where('role', 'vendor')->latest()->paginate(10);
        return view('admin.vendors', compact('vendors'));
    }

    public function manageProducts()
    {
        $products = Product::with('vendor')->latest()->get();
        $vendors = User::where('role', 'vendor')->get();

        return view('admin.manage-products', compact('products', 'vendors'));
    }
}

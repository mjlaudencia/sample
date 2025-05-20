<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
{
    $orders = auth()->user()->orders()->with(['product', 'deliveryPerson'])->get();

    return view('customer.dashboard', compact('orders'));
}
}

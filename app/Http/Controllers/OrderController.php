<?php

// File: app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function placeOrder(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($productId);
    
        $quantity = $request->input('quantity');
        $total = $product->price * $quantity;
    
        Order::create([
        'product_id' => $productId,
        'user_id' => auth()->id(), // use 'user_id' to match the DB column
        'total' => $total,
        'status' => 'pending',
        'delivery_status' => 'pending',
        ]);
    
        return redirect()->route('orders.view')->with('success', 'Order placed successfully.');
    }

public function viewOrders()
{
    $orders = Order::with('product')
        ->where('user_id', auth()->id()) // or user_id, depending on your field
        ->where(function ($query) {
            $query->where('delivery_status', '!=', 'delivered')
                  ->orWhere('updated_at', '>=', Carbon::now()->subDays(2));
        })
        ->latest()
        ->get();

    return view('orders.index', compact('orders'));
}

}

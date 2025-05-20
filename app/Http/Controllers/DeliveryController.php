<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    public function dashboard()
{
    $orders = Order::with(['product', 'deliveryPerson', 'customer'])
        ->where(function ($query) {
            $query->where('delivery_status', '!=', 'delivered')
                  ->orWhere('updated_at', '>=', Carbon::now()->subDays(2));
        })
        ->get();

    return view('delivery.dashboard', compact('orders'));
}

    public function updateStatus(Request $request, Order $order)
    {
        // if ($order->delivery_person_id !== auth()->id()) {
        //     abort(403);
        // }

        $request->validate([
            'delivery_status' => 'required|in:pending,out_for_delivery,delivered',
        ]);

        $order->delivery_status = $request->delivery_status;
        $order->save();

        return back()->with('success', 'Delivery status updated.');
    }
}

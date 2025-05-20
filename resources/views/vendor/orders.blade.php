@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Welcome, {{ auth()->user()->name }}</h2>

        <h3>Your Orders</h3>

        @if ($orders->isEmpty())
            <p>You have no orders yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Customer Name</th>
                        <th>Customer Address</th>
                        <th>Customer Contact</th>
                        <th>Delivery Status</th>
                        <th>Delivery Person</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->name ?? 'Product deleted' }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>₱{{ number_format($order->total, 2) }}</td>

                            {{-- Customer Info --}}
                            <td>{{ $order->customer->name ?? 'N/A' }}</td>
                            <td>{{ $order->customer->address ?? 'N/A' }}</td>
                            <td>{{ $order->customer->contact_number ?? 'N/A' }}</td>

                            <td>{{ ucfirst($order->delivery_status ?? 'Not set') }}</td>
                            <td>{{ optional($order->deliveryPerson)->name ?? 'Not assigned' }}</td>
                            <td>
                                <!-- Edit Order Form -->
                                <form action="{{ route('vendor.orders.update', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <select name="status" class="form-select mb-1" required>
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>

                                    <select name="delivery_status" class="form-select mb-1" required>
                                        <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="out_for_delivery" {{ $order->delivery_status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                        <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>

                                    <select name="delivery_person_id" class="form-select mb-1">
                                        <option value="">-- Assign Delivery Person --</option>
                                        @foreach ($deliveryPeople as $person)
                                            <option value="{{ $person->id }}" {{ $order->delivery_person_id == $person->id ? 'selected' : '' }}>
                                                {{ $person->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

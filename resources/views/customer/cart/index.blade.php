@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart</h2>

    @if($cartItems->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control w-50">
                            <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                        </form>
                    </td>
                    <td>₱{{ $item->product->price }}</td>
                    <td>₱{{ $item->product->price * $item->quantity }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td colspan="2"><strong>₱{{ $totalPrice }}</strong></td>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button class="btn btn-success">Checkout</button>
        </form>
    @else
        <p>Your cart is empty 😢</p>
    @endif
</div>
@endsection

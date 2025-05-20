@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Public Market</a>
        <div class="d-flex align-items-center ms-auto gap-3">
            <span class="fw-semibold fs-5">Hi, {{ Auth::user()->name }}</span>
            <a href="{{ route('vendor.products') }}" class="btn btn-outline-primary btn-sm">Products</a>
            <a href="{{ route('vendor.orders') }}" class="btn btn-outline-primary btn-sm">Orders</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav> -->

<div class="container">
    <h1 class="mb-5 display-5">Welcome, <span class="text-primary">{{ Auth::user()->name }}</span></h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white fs-5">Your Products</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $productCount }} Product(s)</h5>
                    <a href="{{ route('vendor.products') }}" class="btn btn-info">Manage Products</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white fs-5">Orders</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $orderCount }} Order(s)</h5>
                    <a href="{{ route('vendor.orders') }}" class="btn btn-success">View Orders</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fs-5">Total Sales</div>
                <div class="card-body">
                    <h5 class="card-title">₱{{ number_format($totalSales, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

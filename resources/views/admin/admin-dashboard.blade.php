@extends('layouts.layout')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Admin Navbar -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-4 border-bottom">
    <div class="container">
        <a class="navbar-brand text-danger fw-bold" href="{{ route('admin.dashboard') }}">
            Online Public Market
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdminContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdminContent">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-danger" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-danger">Admin Dashboard</h2>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow h-100 bg-light">
                <div class="card-body text-center">
                    <h6 class="text-danger">Vendors</h6>
                    <h2 class="text-dark">{{ $vendors }}</h2>
                    <p class="mb-2">Registered Vendors</p>
                    <a href="{{ route('admin.vendors') }}" class="btn btn-sm btn-danger">Manage</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow h-100 bg-light">
                <div class="card-body text-center">
                    <h6 class="text-danger">Customers</h6>
                    <h2 class="text-dark">{{ $customers }}</h2>
                    <p class="mb-2">Registered Customers</p>
                    <a href="#" class="btn btn-sm btn-danger">View</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow h-100 bg-light">
                <div class="card-body text-center">
                    <h6 class="text-danger">Products</h6>
                    <h2 class="text-dark">{{ $products }}</h2>
                    <p class="mb-2">Listed Products</p>
                    <a href="{{ route('admin.products.manage') }}" class="btn btn-sm btn-danger">Manage</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow h-100 bg-light">
                <div class="card-body text-center">
                    <h6 class="text-danger">Orders</h6>
                    <h2 class="text-dark">{{ $orders }}</h2>
                    <p class="mb-2">Total Orders</p>
                    <a href="#" class="btn btn-sm btn-danger">View</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentOrders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Order #{{ $order->id }} by {{ $order->user->name }}
                            <span class="badge bg-light text-danger">{{ $order->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No recent orders</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">New Vendors</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($vendorList as $vendor)
                        <li class="list-group-item">{{ $vendor->name }}</li>
                    @empty
                        <li class="list-group-item">No vendors yet</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">New Products</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($productList as $product)
                        <li class="list-group-item">{{ $product->name }}</li>
                    @empty
                        <li class="list-group-item">No products yet</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="row mt-5 g-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-3 bg-light border-danger border-2">
                <h5 class="text-danger">Best-Selling Product</h5>
                @if(isset($bestSellingProduct) && $bestSellingProduct)
                    <p>{{ $bestSellingProduct->name }}
                        <span class="badge bg-success">{{ $bestSellingProduct->orders_count }} orders</span>
                    </p>
                @else
                    <p class="text-muted">No sales yet.</p>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3 bg-light border-danger border-2">
                <h5 class="text-danger">Highest-Reviewed Product</h5>
                @if(isset($highestReviewedProduct) && $highestReviewedProduct)
                    <p>{{ $highestReviewedProduct->name }}
                        <span class="badge bg-info text-dark">{{ number_format($highestReviewedProduct->ratings_avg_rating, 1) }} stars</span>
                    </p>
                @else
                    <p class="text-muted">No ratings yet.</p>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3 bg-light border-danger border-2">
                <h5 class="text-danger">Top-Rated Seller</h5>
             @if(isset($highestReviewedSeller) && $highestReviewedSeller)
    <p>{{ $highestReviewedSeller->name }}
        <span class="badge bg-secondary">
            {{ number_format($highestReviewedSeller->ratings_avg_rating ?? 0, 1) }} stars
        </span>
    </p>
@else
    <p class="text-muted">No seller ratings yet.</p>
@endif

            </div>
        </div>
    </div>
</div>

@endsection

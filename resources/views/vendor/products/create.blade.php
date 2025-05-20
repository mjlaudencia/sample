@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Add New Product</h1>

    <!-- Back Button -->
    <a href="{{ route('vendor.products') }}" class="btn btn-secondary mb-3">Back to Product List</a>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="price">Price (₱)</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" required min="0">
                </div>

                <div class="form-group mb-3">
                    <label for="image">Product Image</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                </div>

                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="text-end mt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
@endsection

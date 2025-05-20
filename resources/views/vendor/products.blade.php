@extends('layouts.app')

@section('title', 'Your Products')

@section('content')
<div class="container mt-4">
    <h2>Your Products</h2>
    <a href="{{ route('vendor.products.create') }}" class="btn btn-success mb-3">Add New Product</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price (₱)</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        @if($product->picture)
                            <img src="{{ asset('storage/' . $product->picture) }}" width="60" height="60" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" width="60" height="60">
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $product->id }}">
                            Edit
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('vendor.products.destroy', $product) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

               <!-- EDIT PRODUCT MODAL -->
<div class="modal fade" id="editModal{{ $product->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $product->id }}">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Price (₱)</label>
                        <input type="number" name="price" value="{{ $product->price }}" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Stock</label>
                        <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Product Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($product->picture)
                            <small class="text-muted d-block mt-2">Current image: 
                                <img src="{{ asset('storage/' . $product->picture) }}" width="40" height="40" class="ms-2" style="object-fit: cover;">
                            </small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

                <!-- END EDIT PRODUCT MODAL -->

            @endforeach
        </tbody>
    </table>

    <!-- Logout Button -->
    <div class="text-end mt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>
@endsection

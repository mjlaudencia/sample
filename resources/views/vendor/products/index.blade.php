@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage Your Products</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('vendor.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>
            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
        </div>
    </div>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                    @if ($product->picture)
                    <img src="{{ asset($product->picture) }}" alt="{{ $product->name }}" class="img-fluid mb-3" style="max-height: 150px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="img-fluid mb-3" style="max-height: 150px; object-fit: cover;">
                        @endif
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: ₱{{ number_format($product->price, 2) }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>

                        <button class="btn btn-warning mb-2 edit-button"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-stock="{{ $product->stock }}"
                            data-description="{{ $product->description }}"
                            data-picture="{{ $product->picture }}"
                            data-action="{{ route('vendor.products.update', $product->id) }}"
                            data-bs-toggle="modal"
                            data-bs-target="#editProductModal">
                            Edit
                        </button>

                        <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Back to Vendor Dashboard Button -->
    <div class="mt-4">
        <a href="{{ route('vendor.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <!-- Logout Button -->
    <div class="text-end mt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Name</label>
                        <input type="text" id="edit-name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-price" class="form-label">Price</label>
                        <input type="number" id="edit-price" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-stock" class="form-label">Stock</label>
                        <input type="number" id="edit-stock" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Description</label>
                        <textarea id="edit-description" name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3" id="current-image-container" style="display: none;">
                        <label class="form-label">Current Image</label><br>
                        <img id="current-image-preview" src="" alt="Current Product Image" class="img-fluid mb-2" style="max-height: 100px;">
                    </div>
                    <div class="mb-3">
                        <label for="edit-image" class="form-label">Product Image</label>
                        <input type="file" name="image" id="edit-image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS for populating modal -->
<script>
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = document.getElementById('editProductForm');
            form.action = this.dataset.action;

            document.getElementById('edit-name').value = this.dataset.name;
            document.getElementById('edit-price').value = this.dataset.price;
            document.getElementById('edit-stock').value = this.dataset.stock;
            document.getElementById('edit-description').value = this.dataset.description;

            const imagePath = this.getAttribute('data-picture');
            const imagePreview = document.getElementById('current-image-preview');
            const imageContainer = document.getElementById('current-image-container');

            if (imagePath) {
                imagePreview.src = `/${imagePath}`;
                imageContainer.style.display = 'block';
            } else {
                imageContainer.style.display = 'none';
            }
        });
    });
</script>
@endsection

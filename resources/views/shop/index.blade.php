@extends('layouts.app')

@section('title', 'Online Public Market')

@push('styles')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
        transition: transform 0.4s ease-in-out;
        height: 200px;
        object-fit: cover;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-title,
    .card-text,
    .text-muted {
        transition: color 0.3s ease;
    }

    .card:hover .card-title {
        color: #dc3545 !important;
    }

    .btn-success:hover {
        background-color: #28a745;
        box-shadow: 0 0 15px rgba(40, 167, 69, 0.5);
    }

    .btn-warning:hover {
        background-color: #ffc107;
        box-shadow: 0 0 15px rgba(255, 193, 7, 0.5);
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Check out our goods today</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                    <img src="{{ $product->picture ? asset('storage/' . $product->picture) : asset('images/no-image.png') }}"
                         class="card-img-top"
                         alt="{{ $product->name }}">
                    <div class="card-body text-center">
                        <h5 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h5>
                        <p class="text-muted mb-2">
                            Sold by: <strong>{{ $product->seller->name ?? 'Unknown Seller' }}</strong>
                        </p>
                        <p class="card-text fw-bold text-danger mb-0">₱{{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
            </div>

  <!-- PRODUCT VIEW MODAL -->
<div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body row">
                <div class="col-md-5 text-center">
                    @if ($product->picture)
                        <img src="{{ asset('storage/' . $product->picture) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    @else
                        <img src="{{ asset('default-product.jpg') }}" alt="No image" class="img-fluid rounded">
                    @endif
                </div>

                <div class="col-md-7">
                    <p><strong>Price:</strong> ₱{{ number_format($product->price, 2) }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>
                    <p><strong>Description:</strong> {{ $product->description }}</p>

                    <hr>

                    <!-- Average Rating -->
                    <p>
                        <strong>Average Rating:</strong>
                        @if ($product->averageRating())
                            {{ number_format($product->averageRating(), 1) }} / 5 ⭐
                        @else
                            Not yet rated
                        @endif
                    </p>

                    <!-- Customer Rating Form -->
                    @auth
                        @if (auth()->user()->role === 'customer')
                            <form action="{{ route('ratings.store') }}" method="POST" class="mb-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="mb-2">
                                    <label for="rating" class="form-label">Your Rating</label>
                                    <select name="rating" class="form-select" required>
                                        <option value="">Select Rating</option>
                                        @for ($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label for="review" class="form-label">Review (optional)</label>
                                    <textarea name="review" rows="2" class="form-control" placeholder="Write your review here..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm">Submit Rating</button>
                            </form>
                        @endif
                    @endauth

                    <!-- All Ratings -->
                    <div>
                        <h6>Customer Reviews:</h6>
                        @forelse ($product->ratings as $rating)
                            <div class="border rounded p-2 mb-2">
                                <strong>{{ $rating->user->name }}</strong> 
                                <span class="text-warning">({{ $rating->rating }}★)</span>
                                <p class="mb-0">{{ $rating->review ?? 'No written review.' }}</p>
                                <small class="text-muted">{{ $rating->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <p>No reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    No products available at the moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

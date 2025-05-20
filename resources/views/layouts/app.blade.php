<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Online Public Market')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 600;
            color: #ff2e63 !important;
        }
        .nav-link {
            font-weight: 500;
            color: #333 !important;
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ff2e63 !important;
        }
        .btn-link.nav-link {
            color: #dc3545 !important;
        }
        .container {
            max-width: 960px;
        }
        .navbar-text {
            white-space: nowrap;
            margin-left: 1rem;
        }

        @media (max-width: 576px) {
            .navbar-text {
                font-size: 1rem !important;
                margin-left: 0;
            }
        }
    </style>

     @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50" style="object-fit: contain;">
</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">
                @auth
                    @if(auth()->user()->role === 'customer')
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-text fw-semibold fs-5 text-primary">
                                Welcome Suki {{ auth()->user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.dashboard') }}">
                                Your Orders
                            </a>
                        </li>

                        {{-- 🛒 Yellow Cart Icon Button --}}
                        @php
                            $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->count();
                        @endphp
                        <li class="nav-item">
                            <a href="{{ route('cart.index') }}" class="btn btn-warning position-relative">
                                <i class="bi bi-cart3"></i>
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="border: none; padding: 0;">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

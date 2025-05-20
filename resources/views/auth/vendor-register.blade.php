@extends('layouts.app', ['hideNavbar' => true])

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        background-color: #f8f9fa;
    }
    .form-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start; /* Align items at the top instead of center */
        padding-top: 5px; /* Push down from the very top */
        padding-bottom: 40px;
    }
</style>

<div class="container form-container">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 450px; border-radius: 15px;">

        {{-- Logo --}}
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 150px; height: auto;">
        </div>

        <h2 class="mb-4 text-center" style="color: #d32f2f;">Vendor Registration</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('vendor.register.submit') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Full Name</label>
                <input id="name" 
                       type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus>
                @error('name')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email">Email Address</label>
                <input id="email" 
                       type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required>
                @error('email')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input id="password" 
                       type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" 
                       required>
                @error('password')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" 
                       type="password" 
                       class="form-control" 
                       name="password_confirmation" 
                       required>
            </div>

            <button type="submit" class="btn btn-danger w-100 rounded-pill fw-semibold">
                Register as Vendor
            </button>
        </form>
    </div>
</div>
@endsection

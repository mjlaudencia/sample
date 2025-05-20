@extends('layouts.layout')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px;">
        
        {{-- Logo --}}
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 150px; height: auto;">
        </div>

        <h2 class="text-center mb-4 fw-bold" style="color: #d32f2f;">Login</h2>
        
        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-danger fw-semibold">Login</button>
            </div>
        </form>

        <p class="text-center mt-4 mb-0">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-danger fw-semibold">Register here</a>
        </p>
    </div>
</div>
@endsection

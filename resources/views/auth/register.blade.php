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

        <h2 class="text-center mb-4 fw-bold" style="color: #d32f2f;">Register</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <input 
                    type="text" 
                    name="name" 
                    class="form-control form-control-lg rounded-pill" 
                    placeholder="Name" 
                    required 
                    autofocus
                >
            </div>
            <div class="mb-3">
                <input 
                    type="email" 
                    name="email" 
                    class="form-control form-control-lg rounded-pill" 
                    placeholder="Email" 
                    required
                >
            </div>

            

            <div class="mb-3">
                <input 
                    type="password" 
                    name="password" 
                    class="form-control form-control-lg rounded-pill" 
                    placeholder="Password" 
                    required
                >
            </div>
            <div class="mb-4">
                <input 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control form-control-lg rounded-pill" 
                    placeholder="Confirm Password" 
                    required
                >
            </div>
            <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill fw-semibold">
                Register
            </button>
        </form>

        <p class="text-center mt-4 mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-danger fw-semibold">Login here</a>
        </p>
    </div>
</div>
@endsection

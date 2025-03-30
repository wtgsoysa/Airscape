@extends('layouts.main')

@section('content')
<style>
    body {
        background-color: #ffffff;
    }

    .airscape-logo {
        font-size: 28px;
        font-weight: 700;
        color: #003B3B;
    }

    .airscape-logo span {
        color: #FF6A3D;
    }

    .role-title {
        font-size: 22px;
        font-weight: 600;
        color: #003B3B;
        margin-bottom: 8px;
    }

    .login-subtitle {
        color: #5f6f68;
        margin-bottom: 32px;
    }

    .role-card {
        border: 1px solid #d9ede8;
        background-color: #f2faf8;
        border-radius: 12px;
        padding: 40px 20px;
        transition: 0.2s ease-in-out;
        height: 100%;
    }

    .role-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        transform: translateY(-4px);
    }

    .role-icon {
        font-size: 56px;
        color: #003B3B;
        margin-bottom: 20px;
    }

    .footer-note {
        margin-top: 80px;
        font-size: 14px;
        color: #777;
    }
</style>

<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <!-- Logo -->
    <div class="text-center mb-4">
        <div class="airscape-logo"><img src="/assests/Logo.svg" alt=""></div>
    </div>

    <!-- Title -->
    <h4 class="role-title text-center">Welcome to Admin Panel</h4>
    <p class="login-subtitle text-center">Login as</p>

    <!-- Role selection cards -->
    <div class="row justify-content-center w-100 gap-4 px-3">
        <!-- Web Master -->
        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <a href="{{ route('login.webmaster') }}" class="text-decoration-none">
                <div class="role-card text-center">
                    <div class="role-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h6 class="fw-bold text-dark">WEB MASTER</h6>
                </div>
            </a>
        </div>

        <!-- Administrator -->
        <div class="col-10 col-sm-6 col-md-4 col-lg-3">
            <a href="{{ route('login.admin') }}" class="text-decoration-none">
                <div class="role-card text-center">
                    <div class="role-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h6 class="fw-bold text-dark">ADMINISTRATOR</h6>
                </div>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-note text-center">
        © 2025 airscape - All Rights Reserved.
    </div>
</div>
@endsection

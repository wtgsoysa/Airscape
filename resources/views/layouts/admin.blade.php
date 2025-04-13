@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Airscape Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            background-color: #ffffff;
            font-family: "Segoe UI", sans-serif;
        }

        .sidebar {
            width: 280px;
            background-color: #007872;
            min-height: 100vh;
            padding: 30px 0;
            position: fixed;
        }

        .sidebar a {
            display: block;
            padding: 14px 30px;
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #e7f5f2;
            color: #003B3B;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 50px;
        }

        .sidebar .logo img {
            max-width: 160px;
        }

        .logout-btn {
            background-color: #ff6a3d;
            border: none;
            color: #fff;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 6px;
            margin-top: 40px;
            margin-left: 30px;
        }

        .logout-btn:hover {
            background-color: #ff5a2d;
        }

        .content {
            margin-left: 280px;
            padding: 30px 40px;
        }

        .topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            background-color: #ffffff;
            margin-bottom: 10px;
        }

        .user-badge {
            background-color: #e7f5f2;
            padding: 8px 14px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            color: #003B3B;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column justify-content-between">
    <div>
        <div class="logo">
            <img src="/assests/Logo White.svg" alt="">
        </div>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/sensors">Sensor Management</a>
        <a href="/admin/data-management">Data Management</a>
        <a href="/admin/user-management">AdminUser Management</a>
        <a href="/admin/alert-configuration">Alert Configuration</a>
    </div>
    <div class="px-3">
        <a href="/admin" class="logout-btn d-inline-block text-decoration-none">Logout</a>
        <div class="text-white small mt-4 px-2">© 2025 airscape - All Rights Reserved.</div>
    </div>
</div>

<!-- Main Content -->
<div class="content">
    <div class="topbar">
        @if(Auth::check())
            <div class="user-badge me-2">
                {{ Auth::user()->name }}
                <i class="bi bi-person-circle"></i>
            </div>
        @endif
    </div>

    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Page-specific Scripts -->
@stack('scripts')

</body>
</html>

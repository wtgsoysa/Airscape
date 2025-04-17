<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Airscape | Real-Time Air Quality</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #fff;
            margin: 0;
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar {
            border-bottom: 1px solid #eee;
        }

        .nav-link {
            color: #007872 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #003B3B;
            color: #fff;
            padding: 30px 20px;
            margin-top: 60px;
            text-align: center;
        }

        footer a {
            color: #ffffff;
            margin: 0 10px;
            font-weight: 500;
            text-decoration: none;
        }

        footer img {
            height: 36px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white">
    <div class="container">
        <a class="navbar-brand" href="/user/home">
           <img src="/assests/Logo.svg" alt="Airscape Logo">
        </a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('user.home')); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('user.about')); ?>">About</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo e(route('user.contact')); ?>">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>

<!-- Footer -->
<footer>
    <img src="/assests/Logo.svg" alt="Airscape Logo">
    <div class="mt-3">
        <a href="<?php echo e(route('user.home')); ?>">Home</a> |
        <a href="<?php echo e(route('user.about')); ?>">About</a> |
        <a href="<?php echo e(route('user.contact')); ?>">Contact</a>
    </div>
    <div class="mt-2 text-muted small">© 2025 airscape - All Rights Reserved.</div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH F:\University\SDTP\AirscapeFinal\Airscape\resources\views/layouts/user.blade.php ENDPATH**/ ?>
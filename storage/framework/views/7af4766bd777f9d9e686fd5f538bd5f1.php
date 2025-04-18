<?php $__env->startSection('content'); ?>
<style>
    body {
        background-color: #f7fdfb;
    }
    .login-card {
        border-radius: 16px;
        background-color: #ffffff;
        border: 1px solid #dceee8;
        padding: 40px 30px;
        max-width: 420px;
        width: 100%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }
    .form-label {
        font-weight: 500;
        color: #003B3B;
    }
    .form-control {
        border-radius: 8px;
    }
    .btn-login {
        background-color: #003B3B;
        color: white;
        font-weight: 500;
        border-radius: 8px;
    }
    .btn-login:hover {
        background-color: #005c5c;
    }
    .login-title {
        color: #003B3B;
        font-weight: bold;
        font-size: 22px;
    }
    .airscape-logo {
        font-size: 26px;
        font-weight: bold;
        color: #003B3B;
    }
    .airscape-logo span {
        color: #FF6A3D;
    }
</style>

<div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="text-center mb-4">
        <div class="airscape-logo"><img src="/assests/Logo.svg" alt=""></div>
        <h4 class="login-title mt-3">Web Master Login</h4>
    </div>

    <div class="login-card">
    <form action="<?php echo e(route('login.webmaster.submit')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
                type="email"
                class="form-control"
                id="email"
                name="email"  
                placeholder="webmaster@example.com"
                required
            >
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input
                type="password"
                class="form-control"
                id="password"
                name="password"  
                placeholder="••••••••"
                required
            >
        </div>

        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>
</div>


    <div class="mt-5 text-muted small">
        © 2025 airscape - All Rights Reserved.
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\AirscapeFinal\Airscape\resources\views/auth/webmaster-login.blade.php ENDPATH**/ ?>
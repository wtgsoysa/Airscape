<?php $__env->startSection('content'); ?>
<style>
    .dashboard-status-card {
        background-color: #f0f9f0;
        border-radius: 12px;
        padding: 20px 24px;
        border: 1px solid #d9ede8;
    }

    .dashboard-status-card .title {
        font-weight: 600;
        color: #003B3B;
    }

    .status-badge {
        background-color: #45d16a;
        color: white;
        border-radius: 12px;
        font-size: 14px;
        padding: 4px 10px;
        font-weight: 500;
    }

    .see-more {
        font-size: 14px;
        font-weight: 500;
        color: #005b5b;
        text-decoration: none;
    }

    .see-more:hover {
        text-decoration: underline;
    }

    .dashboard-heading {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 24px;
        color: #003B3B;
    }

    .aqi-data-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        font-size: 16px;
        font-weight: 500;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dashboard-heading">Dashboard</h2>
        <a href="#" class="see-more">see more</a>
    </div>

    <h6 class="text-muted mb-3">Status</h6>

    <div class="dashboard-status-card">
        <div><strong>City</strong></div>
        <div>Colombo Metropolitan Area</div>

        <div class="aqi-data-row mt-3">
            <div><strong>Condition</strong> <span class="status-badge ms-2">Good</span></div>
            <div><strong>AQI</strong> <span class="ms-2">27</span></div>
        </div>
    </div>

    
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\Airscape\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<style>
    .dashboard-wrapper {
        padding: 40px;
        background: linear-gradient(135deg, #e7f5f2, #ffffff);
        min-height: 100vh;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dashboard-header {
        font-size: 26px;
        font-weight: 700;
        color: #003B3B;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-header a {
        font-size: 14px;
        color: #007872;
        text-decoration: none;
        font-weight: 500;
    }

    .sensor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .sensor-tile {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0, 120, 114, 0.1);
        padding: 24px;
        position: relative;
        transition: transform 0.3s ease;
        animation: popUp 0.6s ease;
    }

    .sensor-tile:hover {
        transform: translateY(-5px);
    }

    @keyframes popUp {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .sensor-title {
        font-weight: 600;
        font-size: 18px;
        color: #007872;
    }

    .sensor-meta {
        font-size: 14px;
        color: #666;
        margin-top: 4px;
    }

    .condition-badge {
        padding: 6px 8px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
        margin-top: 10px;
        color: #fff;
    }

    .good { background-color: #45d16a; }
    .moderate { background-color: #f1c232; }
    .unhealthy { background-color: #e76f51; }
    .hazardous { background-color: #8b0000; }

    .progress-track {
        width: 100%;
        background-color: #f0f0f0;
        height: 8px;
        border-radius: 4px;
        margin-top: 12px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .last-updated {
        font-size: 12px;
        margin-top: 12px;
        color: #999;
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-header">
        <div> Realtime Sensor Overview</div>
        <a href="<?php echo e(route('admin.sensors')); ?>">Manage Sensors →</a>
    </div>

    <div class="sensor-grid">
        <?php $__currentLoopData = $sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $aqi = $sensor->simulated_aqi;
                $condition = $badgeClass = $barColor = '';

                if ($aqi <= 50) {
                    $condition = 'Good';
                    $badgeClass = 'good';
                    $barColor = '#45d16a';
                } elseif ($aqi <= 100) {
                    $condition = 'Moderate';
                    $badgeClass = 'moderate';
                    $barColor = '#f1c232';
                } elseif ($aqi <= 200) {
                    $condition = 'Unhealthy';
                    $badgeClass = 'unhealthy';
                    $barColor = '#e76f51';
                } else {
                    $condition = 'Hazardous';
                    $badgeClass = 'hazardous';
                    $barColor = '#8b0000';
                }
            ?>

            <div class="sensor-tile">
                <div class="sensor-title"><?php echo e($sensor->name); ?></div>
                <div class="sensor-meta">📍 <?php echo e($sensor->location); ?></div>

                <div class="condition-badge <?php echo e($badgeClass); ?>"><?php echo e($condition); ?></div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: <?php echo e(min($aqi, 300) / 3); ?>%; background-color: <?php echo e($barColor); ?>;"></div>
                </div>

                <div class="aqi-value mt-2">AQI: <strong><?php echo e($aqi); ?></strong></div>
                <div class="last-updated">🕒 <?php echo e(\Carbon\Carbon::parse($sensor->last_updated)->diffForHumans()); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\AirscapeFinal\Airscape\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
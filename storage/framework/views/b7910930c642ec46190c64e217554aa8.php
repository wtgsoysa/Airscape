<?php $__env->startSection('content'); ?>
<style>
    .section-title {
        font-size: 22px;
        font-weight: 600;
        color: #003B3B;
        margin-bottom: 24px;
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 24px;
    }

    .btn-export, .btn-refresh {
        background-color: #007872;
        color: white;
        font-weight: 500;
    }

    .summary-card {
        padding: 16px;
        border-radius: 12px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
    }

    .summary-card .label {
        color: #777;
        font-weight: 500;
    }

    .aqi-good { background-color: #00E400; color: white; }
    .aqi-moderate { background-color: #FFFF00; color: #000; }
    .aqi-sensitive { background-color: #FF7E00; color: white; }
    .aqi-unhealthy { background-color: #FF0000; color: white; }
    .aqi-verybad { background-color: #8F3F97; color: white; }
    .aqi-hazardous { background-color: #7E0023; color: white; }

    .data-table th {
        background-color: #f0f9f0;
        color: #003B3B;
    }
</style>

<div class="page-wrapper">
    <h4 class="section-title">Data Management</h4>

    <!-- Filters -->
    <form action="<?php echo e(route('admin.data-management.filter')); ?>" method="GET" class="filter-bar align-items-end">
        <div>
            <label class="form-label">Location</label>
            <select name="location" class="form-select">
                <option value="">All</option>
                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($location); ?>" <?php echo e(request('location') == $location ? 'selected' : ''); ?>>
                        <?php echo e($location); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="form-label">From</label>
            <input type="datetime-local" name="from" class="form-control" value="<?php echo e(request('from')); ?>">
        </div>
        <div>
            <label class="form-label">To</label>
            <input type="datetime-local" name="to" class="form-control" value="<?php echo e(request('to')); ?>">
        </div>
        <button type="submit" class="btn btn-refresh">Refresh</button>
        <a href="<?php echo e(route('admin.data-management.export')); ?>" class="btn btn-export">Export CSV</a>
    </form>

    <!-- Chart -->
    <canvas id="aqiChart" height="100" class="mb-4"></canvas>

    <!-- Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Total Records</div>
                <div class="fs-4"><?php echo e($total); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Average AQI</div>
                <div class="fs-4"><?php echo e($average); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Active Sensors</div>
                <div class="fs-4"><?php echo e($activeCount); ?></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Inactive Sensors</div>
                <div class="fs-4"><?php echo e($inactiveCount); ?></div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Sensor ID</th>
                    <th>Location</th>
                    <th>AQI</th>
                    <th>Status</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $aqiClass = $rec->aqi <= 50 ? 'aqi-good' :
                                    ($rec->aqi <= 100 ? 'aqi-moderate' :
                                    ($rec->aqi <= 150 ? 'aqi-sensitive' :
                                    ($rec->aqi <= 200 ? 'aqi-unhealthy' :
                                    ($rec->aqi <= 300 ? 'aqi-verybad' : 'aqi-hazardous'))));
                    ?>
                    <tr>
                        <td><?php echo e($rec->sensor_id); ?></td>
                        <td><?php echo e($rec->location); ?></td>
                        <td><span class="<?php echo e($aqiClass); ?>"><?php echo e($rec->aqi); ?></span></td>
                        <td><span class="badge <?php echo e($rec->status === 'Active' ? 'bg-success' : 'bg-danger'); ?>"><?php echo e($rec->status); ?></span></td>
                        <td><?php echo e($rec->recorded_at); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('aqiChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chartLabels); ?>,
            datasets: [{
                label: 'AQI Over Time',
                data: <?php echo json_encode($chartValues); ?>,
                borderColor: '#007872',
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                x: { title: { display: true, text: 'Time' }},
                y: { title: { display: true, text: 'AQI' }, beginAtZero: true }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\AirscapeFinalVersion\Airscape\resources\views/pages/admin/data-management.blade.php ENDPATH**/ ?>
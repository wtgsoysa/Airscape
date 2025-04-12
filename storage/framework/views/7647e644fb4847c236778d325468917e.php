<?php $__env->startSection('content'); ?>
<style>
    .alert-section-title {
        font-size: 24px;
        font-weight: 700;
        color: #003B3B;
        margin-bottom: 30px;
    }

    .card-alert, .card-system-alert {
        background: #ffffff;
        border: 1px solid #e0f1ef;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .rule-label {
        font-weight: 600;
        color: #007872;
    }

    .threshold-input {
        width: 100px;
        border-radius: 8px;
        padding: 6px 10px;
        border: 1px solid #ccc;
    }

    .btn-add-rule {
        background-color: #007872;
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 500;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-switch .form-check-input {
        width: 42px;
        height: 24px;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .system-alert-header {
        font-size: 18px;
        font-weight: 600;
        color: #003B3B;
        margin-top: 40px;
        margin-bottom: 16px;
    }

    .alert-log-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        border: 1px solid #e6f0ee;
        border-radius: 10px;
        background-color: #f8fdfa;
        margin-bottom: 10px;
    }

    .alert-log-item .alert-type {
        font-weight: 600;
        color: #007872;
    }

    .alert-log-item .alert-time {
        color: #777;
        font-size: 14px;
    }
</style>

<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="alert-section-title">⚠️ Alert Configuration</h4>
        <button class="btn btn-add-rule" data-bs-toggle="modal" data-bs-target="#addAlertModal">
            <i class="bi bi-plus-circle me-1"></i> Add Rule
        </button>
    </div>

    <?php
        $alerts = [
            ['type' => 'PM2.5', 'threshold' => 100, 'freq' => 'Every 15 mins', 'email' => true, 'system' => true],
            ['type' => 'CO2', 'threshold' => 900, 'freq' => 'Every 30 mins', 'email' => true, 'system' => false],
            ['type' => 'PM10', 'threshold' => 120, 'freq' => 'Hourly', 'email' => false, 'system' => true],
        ];
    ?>

    <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card-alert">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="rule-label"><?php echo e($alert['type']); ?></div>
                <small class="text-muted">Pollutant Type</small>
            </div>
            <div class="col-md-2">
                <input type="number" value="<?php echo e($alert['threshold']); ?>" class="threshold-input">
                <small class="text-muted d-block">Threshold (μg/m³)</small>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option <?php echo e($alert['freq'] == 'Every 15 mins' ? 'selected' : ''); ?>>Every 15 mins</option>
                    <option <?php echo e($alert['freq'] == 'Every 30 mins' ? 'selected' : ''); ?>>Every 30 mins</option>
                    <option <?php echo e($alert['freq'] == 'Hourly' ? 'selected' : ''); ?>>Hourly</option>
                </select>
                <small class="text-muted d-block">Check Frequency</small>
            </div>
            <div class="col-md-2 toggle-switch">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" <?php echo e($alert['email'] ? 'checked' : ''); ?>>
                </div>
                <div>Email Alert</div>
            </div>
            <div class="col-md-2 toggle-switch">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" <?php echo e($alert['system'] ? 'checked' : ''); ?>>
                </div>
                <div>System Alert</div>
            </div>
            <div class="col-md-2 text-end">
                <div class="dropdown">
                    <button class="btn border-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                        <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- System Alerts Log -->
    <div class="system-alert-header">🛑 Recent System Alerts</div>
    <div class="card-system-alert">
        <?php
            $systemAlerts = [
                ['type' => 'CO2 exceeded safe level', 'time' => '2025-03-30 18:05'],
                ['type' => 'PM2.5 spike detected', 'time' => '2025-03-30 17:43'],
                ['type' => 'Unhealthy AQI reported in Dehiwala', 'time' => '2025-03-30 16:29']
            ];
        ?>

        <?php $__currentLoopData = $systemAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert-log-item">
            <div>
                <div class="alert-type"><?php echo e($alert['type']); ?></div>
                <div class="alert-time"><?php echo e($alert['time']); ?></div>
            </div>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<!-- Add Alert Modal -->
<div class="modal fade" id="addAlertModal" tabindex="-1" aria-labelledby="addAlertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <h5 class="fw-bold text-teal">New Alert Rule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form>
        <div class="mb-3">
            <label class="form-label">Pollutant Type</label>
            <select class="form-select">
                <option>PM2.5</option>
                <option>PM10</option>
                <option>CO2</option>
                <option>NO2</option>
                <option>O3</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Threshold (μg/m³)</label>
            <input type="number" class="form-control" placeholder="e.g., 100">
        </div>

        <div class="mb-3">
            <label class="form-label">Alert Frequency</label>
            <select class="form-select">
                <option>Every 15 mins</option>
                <option>Every 30 mins</option>
                <option>Hourly</option>
                <option>Daily</option>
            </select>
        </div>

        <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="emailSwitch" checked>
            <label class="form-check-label" for="emailSwitch">Enable Email Alerts</label>
        </div>

        <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="systemSwitch" checked>
            <label class="form-check-label" for="systemSwitch">Enable System Alerts</label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-add-rule">Save Rule</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\Airscape\resources\views/pages/admin/alert-configuration.blade.php ENDPATH**/ ?>
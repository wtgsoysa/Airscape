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

    
    <?php $__currentLoopData = $rules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card-alert">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="rule-label"><?php echo e($alert->pollutant_type); ?></div>
                <small class="text-muted">Pollutant Type</small>
            </div>
            <div class="col-md-2">
                <input type="number" value="<?php echo e($alert->threshold); ?>" class="threshold-input" disabled>
                <small class="text-muted d-block">Threshold (μg/m³)</small>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" value="<?php echo e($alert->frequency); ?>" disabled>
                <small class="text-muted d-block">Frequency</small>
            </div>
            <div class="col-md-2 toggle-switch">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" <?php echo e($alert->email_alert ? 'checked' : ''); ?> disabled>
                </div>
                <div>Email Alert</div>
            </div>
            <div class="col-md-2 toggle-switch">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" <?php echo e($alert->system_alert ? 'checked' : ''); ?> disabled>
                </div>
                <div>System Alert</div>
            </div>
            <div class="col-md-2 text-end">
                <form action="<?php echo e(route('alert.configuration.delete', $alert->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this rule?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div class="system-alert-header">🛑 Recent System Alerts</div>
    <div class="card-system-alert">
        <?php $__empty_1 = true; $__currentLoopData = $recentAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="alert-log-item">
            <div>
                <div class="alert-type">
                    <?php echo str_contains($log['message'], '⚠️') ? $log['message'] : '📘 ' . $log['message']; ?>

                </div>
                <div class="alert-time"><?php echo e(\Carbon\Carbon::parse($log['created_at'])->format('Y-m-d H:i')); ?></div>
            </div>
            <button class="btn btn-sm btn-outline-danger delete-alert" data-id="<?php echo e($log['id']); ?>">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-muted">No alerts available.</div>
        <?php endif; ?>
    </div>

    
    <div class="card mt-5" style="border-left: 5px solid #007872; background-color: #f9fffe;">
        <div class="card-body">
            <h5 class="fw-bold text-dark mb-3">🧠 How to Use Alert Configuration</h5>
            <div class="mb-3">
                <span class="fw-semibold text-dark">📌 Pollutant Type</span>
                <p class="text-muted mb-2">Select the air quality component you want to monitor.</p>
                <ul class="text-muted small mb-0">
                    <li><strong>PM2.5 / PM10</strong> – Fine dust particles (harmful to lungs).</li>
                    <li><strong>CO2</strong> – Indicates poor ventilation.</li>
                    <li><strong>NO2 / O3</strong> – Gases causing respiratory issues.</li>
                </ul>
            </div>
            <div class="mb-3">
                <span class="fw-semibold text-dark">📌 Threshold (μg/m³)</span>
                <p class="text-muted mb-0">Set the danger level. System triggers an alert when this value is exceeded.</p>
            </div>
            <div class="mb-3">
                <span class="fw-semibold text-dark">📌 Frequency</span>
                <p class="text-muted mb-0">How often should the system check? Use <strong>15 mins</strong> for critical areas, <strong>Hourly</strong> or <strong>Daily</strong> for general zones.</p>
            </div>
            <div class="mb-2">
                <span class="fw-semibold text-dark">📌 Alerts</span>
                <ul class="text-muted small mb-0">
                    <li><strong>Email Alert</strong> – Sends alert to your inbox.</li>
                    <li><strong>System Alert</strong> – Shows in dashboard's alert log.</li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addAlertModal" tabindex="-1" aria-labelledby="addAlertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <h5 class="fw-bold text-teal">New Alert Rule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="<?php echo e(route('alert.configuration.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="mb-3">
            <label class="form-label">Pollutant Type</label>
            <select name="pollutant_type" class="form-select" required>
                <option value="" disabled selected>Select pollutant type</option>
                <option value="AQI">AQI</option>
                <option value="PM2.5">PM2.5</option>
                <option value="PM10">PM10</option>
                <option value="CO2">CO2</option>
                <option value="NO2">NO2</option>
                <option value="O3">O3</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Threshold (μg/m³)</label>
            <input name="threshold" type="number" class="form-control" placeholder="e.g., 100" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Frequency</label>
            <select name="check_frequency" class="form-select" required>
                <option>Every 15 mins</option>
                <option>Every 30 mins</option>
                <option>Hourly</option>
                <option>Daily</option>
            </select>
        </div>

        <div class="form-check form-switch mb-2">
            <input class="form-check-input" name="email_alert" type="checkbox" id="emailSwitch" checked>
            <label class="form-check-label" for="emailSwitch">Enable Email Alerts</label>
        </div>

        <div class="form-check form-switch mb-4">
            <input class="form-check-input" name="system_alert" type="checkbox" id="systemSwitch" checked>
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

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-alert').forEach(button => {
            button.addEventListener('click', function () {
                const item = this.closest('.alert-log-item');
                const alertId = this.dataset.id;

                if (!alertId) {
                    item.remove();
                    return;
                }

                fetch(`/admin/system-alerts/${alertId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (res.ok) {
                        item.remove();
                    } else {
                        alert('Failed to delete alert.');
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\University\SDTP\AirscapeFinalVersion\Airscape\resources\views/pages/admin/alert-configuration.blade.php ENDPATH**/ ?>
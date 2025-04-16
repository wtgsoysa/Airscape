@extends('layouts.admin')

@section('content')
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

    {{-- Alert Rules List --}}
    @foreach($rules as $alert)
    <div class="card-alert">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="rule-label">{{ $alert->pollutant_type }}</div>
                <small class="text-muted">Pollutant Type</small>
            </div>
            <div class="col-md-2">
                <input type="number" value="{{ $alert->threshold }}" class="threshold-input" disabled>
                <small class="text-muted d-block">Threshold (μg/m³)</small>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" value="{{ $alert->frequency }}" disabled>
                <small class="text-muted d-block">Frequency</small>
            </div>
            <div class="col-md-2 toggle-switch">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" {{ $alert->email_alert ? 'checked' : '' }} disabled>
                </div>
                <div>Email Alert</div>
            </div>
            <div class="col-md-2 toggle-switch">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" {{ $alert->system_alert ? 'checked' : '' }} disabled>
                </div>
                <div>System Alert</div>
            </div>
            <div class="col-md-2 text-end">
                <form action="{{ route('alert.configuration.delete', $alert->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this rule?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    {{-- System Alerts Log --}}
    <div class="system-alert-header">🛑 Recent System Alerts</div>
    <div class="card-system-alert">
        @foreach($recentAlerts as $log)
        <div class="alert-log-item">
            <div>
                <div class="alert-type">{{ $log['message'] }}</div>
                <div class="alert-time">{{ \Carbon\Carbon::parse($log['created_at'])->format('Y-m-d H:i') }}</div>
            </div>
            <button class="btn btn-sm btn-outline-danger delete-alert" data-id="{{ $log['id'] ?? '' }}">
                <i class="bi bi-x-lg"></i>
            </button>

        </div>
        @endforeach
    </div>

    {{-- Admin Guide --}}
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

{{-- Add Alert Modal --}}
<div class="modal fade" id="addAlertModal" tabindex="-1" aria-labelledby="addAlertModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <h5 class="fw-bold text-teal">New Alert Rule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('alert.configuration.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Pollutant Type</label>
            <select name="pollutant_type" class="form-select" required>
                <option>PM2.5</option>
                <option>PM10</option>
                <option>CO2</option>
                <option>NO2</option>
                <option>O3</option>
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
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-alert').forEach(button => {
            button.addEventListener('click', function () {
                const item = this.closest('.alert-log-item');
                const alertId = this.dataset.id;

                if (!alertId) {
                    // No ID, remove the alert from UI only (static)
                    item.remove();
                    return;
                }

                fetch(`/admin/system-alerts/${alertId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (res.ok) {
                        item.remove();
                    } else {
                        alert('Failed to delete alert. Please try again.');
                    }
                });
            });
        });
    });
</script>
@endpush


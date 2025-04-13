@extends('layouts.admin')

@section('content')
<style>
    .section-title {
        font-size: 22px;
        font-weight: 600;
        color: #003B3B;
        margin-bottom: 24px;
    }
    .sensor-card {
        background-color: #f0f9f0;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #cde7de;
        width: 100%;
        position: relative;
    }
    .sensor-id {
        position: absolute;
        top: 14px;
        right: 16px;
        font-size: 13px;
        font-weight: 600;
        color: #777;
    }
    .status-badge {
        background-color: #45d16a;
        color: white;
        border-radius: 12px;
        font-size: 14px;
        padding: 4px 12px;
        font-weight: 500;
    }
    .btn-add {
        background-color: #007872;
        color: white;
        border: none;
        padding: 8px 20px;
        font-weight: 500;
        border-radius: 8px;
    }
    .btn-add:hover {
        background-color: #00635f;
    }
    .modal-content {
        border-radius: 16px;
    }
    .page-wrapper {
        background-color: #ffffff;
        padding: 40px;
        min-height: 100vh;
    }
    #map {
        height: 500px;
        width: 100%;
        border-radius: 12px;
    }
    .sensor-scroll {
        max-height: 500px;
        overflow-y: auto;
    }
    .delete-icon {
        position: absolute;
        bottom: 16px;
        right: 20px;
        cursor: pointer;
        color: #d62828;
    }
    .delete-icon:hover {
        color: #a11d1d;
    }
</style>

<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="section-title mb-0">Sensor Management</h4>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addSensorModal">Add Sensor</button>
    </div>

    <div class="row gx-5">
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div id="map"></div>
        </div>

        <div class="col-lg-5 sensor-scroll">
            @foreach($sensors as $sensor)
            <div class="sensor-card mb-4">
                <div class="sensor-id">#{{ $sensor->sensor_id }}</div>
                <div><strong>City</strong></div>
                <div>{{ $sensor->location }}</div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div><strong>Status</strong>
                        <span class="status-badge ms-2">{{ $sensor->status }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.sensors.delete', $sensor->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-icon border-0 bg-transparent"><i class="bi bi-trash-fill" title="Delete"></i></button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Add Sensor Modal -->
<div class="modal fade" id="addSensorModal" tabindex="-1" aria-labelledby="addSensorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-4">
            <div class="d-flex justify-content-between align-items-start">
                <h5 class="fw-bold text-teal">New Sensor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <p class="text-muted mb-4">Add a new sensor to your city</p>

            <form method="POST" action="{{ route('admin.sensors.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Sensor Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Station 05 - Colombo South" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sensor ID</label>
                        <input type="text" name="sensor_id" class="form-control" placeholder="e.g., S005" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location / Area</label>
                        <input type="text" name="location" class="form-control" placeholder="Colombo Metropolitan Area" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">AQI Baseline</label>
                        <input type="number" name="baseline_aqi" class="form-control" placeholder="35" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Simulation Frequency (min)</label>
                        <input type="number" name="frequency" class="form-control" placeholder="10" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Variation (%)</label>
                        <input type="number" name="variation" class="form-control" placeholder="5" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control" placeholder="e.g., 6.9271" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control" placeholder="e.g., 79.8612" required>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-add">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([6.85, 79.88], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const sensors = @json($sensors);

    function getAQIStatus(aqi) {
        if (aqi <= 50) return '🟢 Good';
        if (aqi <= 100) return '🟡 Moderate';
        if (aqi <= 150) return '🟠 Unhealthy for Sensitive Groups';
        if (aqi <= 200) return '🔴 Unhealthy';
        if (aqi <= 300) return '🟣 Very Unhealthy';
        return '⚫ Hazardous';
    }

    sensors.forEach(sensor => {
        const aqiStatus = getAQIStatus(sensor.simulated_aqi);

        const popupContent = `
            <div style="font-family:'Segoe UI'; font-size:14px;">
                <h6 class="fw-bold mb-1">🚨 ${sensor.name}</h6>
                <div><strong>📍 Location:</strong> ${sensor.location}</div>
                <div><strong>📊 AQI:</strong> ${sensor.simulated_aqi} <span>${aqiStatus}</span></div>
                <div><strong>📌 Status:</strong> ${sensor.status}</div>
                <div><strong>🕒 Updated:</strong> ${sensor.last_updated}</div>
                <hr>
                <div style="color:#d62828;"><strong>Risk:</strong> High for all groups</div>
                <div style="color:#007872;"><strong>Tip:</strong> Avoid outdoor activity. Mask is recommended.</div>
            </div>
        `;

        L.marker([sensor.latitude, sensor.longitude])
            .addTo(map)
            .bindPopup(popupContent);
    });
</script>
@endpush

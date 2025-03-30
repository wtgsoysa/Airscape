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
    }

    .status-badge {
        background-color: #45d16a;
        color: white;
        border-radius: 12px;
        font-size: 14px;
        padding: 4px 12px;
        font-weight: 500;
    }

    .dropdown-toggle::after {
        display: none;
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
</style>

<div class="page-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="section-title mb-0">Sensor Management</h4>
        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addSensorModal">Add Sensor</button>
    </div>

    <div class="row gx-5">
        <!-- Left: Leaflet Map -->
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div id="map"></div>
        </div>

        <!-- Right: Sensor Cards -->
        <div class="col-lg-5 sensor-scroll">
            <!-- Colombo -->
            <div class="sensor-card mb-4">
                <div><strong>City</strong></div>
                <div>Colombo</div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div><strong>Status</strong> <span class="status-badge ms-2">Active</span></div>
                </div>
            </div>

            <!-- Dehiwala -->
            <div class="sensor-card mb-4">
                <div><strong>City</strong></div>
                <div>Dehiwala</div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div><strong>Status</strong> <span class="status-badge ms-2">Active</span></div>
                </div>
            </div>

            <!-- Kotte -->
            <div class="sensor-card mb-4">
                <div><strong>City</strong></div>
                <div>Sri Jayawardenapura Kotte</div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div><strong>Status</strong> <span class="status-badge ms-2">Active</span></div>
                </div>
            </div>

            <!-- Moratuwa -->
            <div class="sensor-card mb-4">
                <div><strong>City</strong></div>
                <div>Moratuwa</div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div><strong>Status</strong> <span class="status-badge ms-2">Active</span></div>
                </div>
            </div>
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

      <form action="#" method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Sensor Name</label>
                <input type="text" class="form-control" placeholder="e.g., Station 05 - Colombo South">
            </div>

            <div class="col-md-6">
                <label class="form-label">Sensor ID</label>
                <input type="text" class="form-control" placeholder="Unique ID">
            </div>

            <div class="col-md-6">
                <label class="form-label">Location / Area</label>
                <input type="text" class="form-control" value="Colombo Metropolitan Area">
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-select">
                    <option selected>Active</option>
                    <option>Inactive</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">AQI Baseline</label>
                <input type="number" class="form-control" placeholder="e.g., 35">
            </div>

            <div class="col-md-4">
                <label class="form-label">Simulation Frequency (min)</label>
                <input type="number" class="form-control" placeholder="e.g., 10">
            </div>

            <div class="col-md-4">
                <label class="form-label">Variation (%)</label>
                <input type="number" class="form-control" placeholder="e.g., 5">
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
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([6.85, 79.88], 11); // Center between cities

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Sensor markers
    const sensors = [
        { name: "Colombo Sensor", coords: [6.9271, 79.8612] },
        { name: "Dehiwala Sensor", coords: [6.8506, 79.8656] },
        { name: "Kotte Sensor", coords: [6.8918, 79.9182] },
        { name: "Moratuwa Sensor", coords: [6.7730, 79.8815] }
    ];

    sensors.forEach(sensor => {
        L.marker(sensor.coords)
            .addTo(map)
            .bindPopup(`<strong>${sensor.name}</strong><br>Status: Active`);
    });
</script>
@endpush

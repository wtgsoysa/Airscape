@extends('layouts.user')

@section('content')
<style>
    .hero {
        text-align: center;
        padding: 60px 20px 30px;
    }

    .hero h2 {
        font-size: 32px;
        font-weight: 700;
        color: #003B3B;
        margin-bottom: 10px;
    }

    .hero p {
        font-size: 16px;
        color: #555;
        max-width: 500px;
        margin: 0 auto;
    }

    .map-section {
        padding: 40px 20px;
    }

    #map {
        height: 350px;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
</style>

<div class="hero">
    <h2>Know Your Air</h2>
    <p>Real-Time Air Quality In Colombo</p>
</div>

<div class="map-section">
    <h5 class="text-center mb-4">📍 AQI Monitoring Map</h5>
    <div id="map"></div>
</div>

<!-- Sensor AQI Modal -->
<div class="modal fade" id="sensorAqiModal" tabindex="-1" aria-labelledby="sensorAqiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4" style="border-radius: 16px;">
      <h6 class="fw-bold mb-2 text-muted">Current AQI Value <span class="float-end fs-2 text-dark">50</span></h6>
      <span class="badge bg-success mb-2">Good</span>
      <p class="text-muted small">Air quality is acceptable. But there may be a risk for someone with 24 hours exposure.</p>
      
      <div class="mb-3">
        <div class="d-flex justify-content-between mb-1"><span>PM₁₀</span><span>30</span></div>
        <div class="progress mb-2" style="height: 6px;"><div class="progress-bar bg-danger" style="width: 30%"></div></div>

        <div class="d-flex justify-content-between mb-1"><span>O₃</span><span>30</span></div>
        <div class="progress mb-2" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 30%"></div></div>

        <div class="d-flex justify-content-between mb-1"><span>NO₂</span><span>30</span></div>
        <div class="progress mb-2" style="height: 6px;"><div class="progress-bar bg-success" style="width: 30%"></div></div>

        <div class="d-flex justify-content-between mb-1"><span>SO₂</span><span>30</span></div>
        <div class="progress mb-3" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 30%"></div></div>
      </div>

      <div class="d-flex justify-content-between text-center text-white bg-teal rounded px-3 py-2" style="background-color: #007872;">
        <div>Now<br><strong>56</strong></div>
        <div>10 Min<br><strong>56</strong></div>
        <div>30 Min<br><strong>56</strong></div>
        <div>1 Hr<br><strong>56</strong></div>
        <div>6 Hr<br><strong>56</strong></div>
        <div>1 Day<br><strong>56</strong></div>
        <div>1 Week<br><strong>56</strong></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([6.9271, 79.8612], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const sensors = [
        { name: "Colombo", coords: [6.9271, 79.8612] },
        { name: "Dehiwala", coords: [6.8506, 79.8656] },
        { name: "Kotte", coords: [6.8918, 79.9182] }
    ];

    sensors.forEach(sensor => {
        const marker = L.marker(sensor.coords).addTo(map);
        marker.bindPopup(`
            <strong>${sensor.name}</strong><br>
            <button class="btn btn-sm btn-primary mt-2" onclick="showSensorModal()">View AQI</button>
        `);
    });

    function showSensorModal() {
        const modal = new bootstrap.Modal(document.getElementById('sensorAqiModal'));
        modal.show();
    }
</script>
@endpush

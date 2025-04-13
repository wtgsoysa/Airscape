<?php $__env->startSection('content'); ?>
<style>
    body {
        background: linear-gradient(to bottom, #f4fcfb, #e6f9f7);
        font-family: 'Segoe UI', sans-serif;
    }

    .banner {
        background: linear-gradient(135deg, #007872, #00c9a7);
        color: white;
        text-align: center;
        padding: 70px 20px;
        border-radius: 0 0 40px 40px;
    }

    .banner h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .banner p {
        font-size: 20px;
        opacity: 0.9;
    }

    .live-clock {
        margin-top: 12px;
        font-weight: 500;
        font-size: 18px;
    }

    .sensor-section {
        padding: 50px 20px;
    }

    .sensor-title {
        font-size: 26px;
        font-weight: 700;
        color: #003B3B;
        text-align: center;
        margin-bottom: 30px;
    }

    .sensor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
    }

    .sensor-card {
        background-color: #fff;
        border: 1px solid #d9f2ed;
        border-radius: 18px;
        padding: 24px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .sensor-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }

    .sensor-card h5 {
        color: #007872;
        font-weight: 700;
    }

    .aqi-badge {
        padding: 8px 16px;
        font-size: 15px;
        font-weight: 600;
        border-radius: 16px;
        display: inline-block;
        margin-top: 12px;
    }

    .aqi-good { background: #00E400; color: white; }
    .aqi-moderate { background: #FFFF00; color: #333; }
    .aqi-unhealthy { background: #FF0000; color: white; }

    .map-section {
        margin-top: 60px;
    }

    #map {
        height: 450px;
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 6px 14px rgba(0,0,0,0.06);
    }

    .tip-box {
        background: #e6fdf3;
        padding: 20px;
        margin-top: 50px;
        border-left: 6px solid #00c98d;
        border-radius: 14px;
        font-size: 16px;
        text-align: center;
        font-weight: 500;
    }

    .refresh-btn {
        margin-top: 20px;
        text-align: center;
        font-weight: 600;
        color: #007872;
        cursor: pointer;
        text-decoration: underline;
    }
</style>

<!-- Banner -->
<div class="banner">
    <h1>AirScape</h1>
    <p>Live. Smart. Clean – Your Colombo Air Quality Companion</p>
    <div class="live-clock" id="liveClock">🕒 Loading time...</div>
</div>

<!-- Sensor Cards -->
<div class="sensor-section">
    <div class="sensor-title">🌐 Colombo Sensor Network</div>
    <div class="sensor-grid">
        <div class="sensor-card">
            <h5>Colombo</h5>
            <span class="aqi-badge aqi-good">AQI 42 - Good</span>
        </div>
        <div class="sensor-card">
            <h5>Dehiwala</h5>
            <span class="aqi-badge aqi-moderate">AQI 95 - Moderate</span>
        </div>
        <div class="sensor-card">
            <h5>Kotte</h5>
            <span class="aqi-badge aqi-unhealthy">AQI 152 - Unhealthy</span>
        </div>
    </div>
</div>

<!-- Map -->
<div class="sensor-section map-section">
    <div class="sensor-title">📍 Interactive AQI Map</div>
    <div id="map"></div>
</div>

<!-- Tip Section -->
<div class="container">
    <div class="tip-box">
        🌱 <strong>Did You Know?</strong> Replacing one car trip per week with cycling or walking can help prevent 4.4 kg of CO₂ emissions.
    </div>
    <div class="refresh-btn" onclick="location.reload()">🔄 Refresh Air Data</div>
</div>

<!-- Modal -->
<div class="modal fade" id="sensorAqiModal" tabindex="-1" aria-labelledby="sensorAqiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4" style="border-radius: 18px;">
      <h6 class="fw-bold mb-2 text-muted">Current AQI Value <span class="float-end fs-2 text-dark">50</span></h6>
      <span class="badge bg-success mb-2">Good</span>
      <p class="text-muted small">Air quality is acceptable. Risk may exist after long-term exposure.</p>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([6.9271, 79.8612], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    const sensors = [
        { name: "Colombo", coords: [6.9271, 79.8612], aqi: 42 },
        { name: "Dehiwala", coords: [6.8506, 79.8656], aqi: 95 },
        { name: "Kotte", coords: [6.8918, 79.9182], aqi: 152 }
    ];

    sensors.forEach(sensor => {
        const popup = `<strong>${sensor.name}</strong><br>AQI: ${sensor.aqi}<br><button class='btn btn-sm btn-outline-primary mt-2' onclick='showSensorModal()'>More</button>`;
        L.marker(sensor.coords).addTo(map).bindPopup(popup);
    });

    function showSensorModal() {
        const modal = new bootstrap.Modal(document.getElementById('sensorAqiModal'));
        modal.show();
    }

    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').textContent = "🕒 " + now.toLocaleTimeString();
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dinuli Nethmini\Desktop\Uni Works\Y2 S2\SQA\Airscape\Airscape\resources\views/pages/user/home.blade.php ENDPATH**/ ?>
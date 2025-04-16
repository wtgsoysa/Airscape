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
        <?php $__currentLoopData = $sensors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sensor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $class = $sensor->current_aqi <= 50 ? 'aqi-good' :
                    ($sensor->current_aqi <= 100 ? 'aqi-moderate' : 'aqi-unhealthy');
            $label = $sensor->current_aqi <= 50 ? 'Good' :
                    ($sensor->current_aqi <= 100 ? 'Moderate' : 'Unhealthy');
        ?>
        <div class="sensor-card">
            <h5><?php echo e($sensor->name); ?></h5>
            <span class="aqi-badge <?php echo e($class); ?>">AQI <?php echo e($sensor->current_aqi); ?> - <?php echo e($label); ?></span>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const map = L.map('map').setView([6.85, 79.88], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const sensors = <?php echo json_encode($sensors, 15, 512) ?>;

    function getAQILevel(aqi) {
        if (aqi <= 50) return { level: 'Good', color: 'good', note: 'Air quality is satisfactory.' };
        if (aqi <= 100) return { level: 'Moderate', color: 'moderate', note: 'Moderate health concern.' };
        if (aqi <= 200) return { level: 'Unhealthy', color: 'unhealthy', note: 'Unhealthy for sensitive groups.' };
        return { level: 'Hazardous', color: 'hazardous', note: 'Health alert for all.' };
    }

    sensors.forEach(sensor => {
        const aqiData = getAQILevel(sensor.current_aqi);
        const popupContent = `
            <div style="font-size: 14px;">
                <h6>🚨 ${sensor.name}</h6>
                <p><strong>Location:</strong> ${sensor.location}</p>
                <p><strong>Status:</strong> ${sensor.status}</p>
                <p><strong>AQI:</strong> <span class="popup-aqi ${aqiData.color}">${sensor.current_aqi} (${aqiData.level})</span></p>
                <p><strong>Update Frequency:</strong> Every ${sensor.frequency} min</p>
                <p><strong>Variation:</strong> ±${sensor.variation}%</p>
                <p><strong>Last Updated:</strong> ${sensor.last_updated}</p>
                <p><strong>Risk Level:</strong> ${aqiData.level === 'Hazardous' ? 'Very High' : aqiData.level}</p>
                <p><strong>Recommendation:</strong> ${aqiData.note}</p>
            </div>
        `;

        L.marker([sensor.latitude, sensor.longitude])
            .addTo(map)
            .bindPopup(popupContent);
    });


    function updateClock() {
        const now = new Date();
        document.getElementById('liveClock').textContent = "🕒 " + now.toLocaleTimeString();
    }

    setInterval(updateClock, 1000);
    updateClock();
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\akila\Desktop\uni\Airscape\Airscape\resources\views/pages/user/home.blade.php ENDPATH**/ ?>
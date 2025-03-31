@extends('layouts.user') {{-- or use layouts.user if you have a separate one --}}

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

    .aqi-box {
        background-color: #e8f7ee;
        color: #007872;
        font-weight: 600;
        padding: 10px 18px;
        border-radius: 12px;
        display: inline-block;
        font-size: 18px;
        margin-bottom: 20px;
    }

    .aqi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 20px;
        text-align: center;
        padding: 0 20px;
    }

    .aqi-card {
        background-color: #ffffff;
        border: 1px solid #e3f2ef;
        border-radius: 12px;
        padding: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .aqi-card .label {
        font-weight: 600;
        color: #555;
        margin-bottom: 6px;
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

    .footer {
        background-color: #003B3B;
        color: #fff;
        padding: 30px;
        margin-top: 50px;
        text-align: center;
    }

    .footer a {
        color: #fff;
        margin: 0 10px;
        font-weight: 500;
        text-decoration: none;
    }
</style>

<div class="hero">
    <h2>Know Your Air</h2>
    <p>Real-time Air Quality Index across the Colombo Metropolitan Region</p>
</div>

<div class="text-center my-3">
    <div class="aqi-box">Colombo AQI: 27 <span class="badge bg-success ms-2">Good</span></div>
</div>

<div class="aqi-grid">
    <div class="aqi-card">
        <div class="label">PM2.5</div>
        <div>30 μg/m³</div>
    </div>
    <div class="aqi-card">
        <div class="label">O₃</div>
        <div>20 μg/m³</div>
    </div>
    <div class="aqi-card">
        <div class="label">NO₂</div>
        <div>29 μg/m³</div>
    </div>
    <div class="aqi-card">
        <div class="label">SO₂</div>
        <div>35 μg/m³</div>
    </div>
</div>

<div class="map-section">
    <h5 class="text-center mb-4">📍 AQI Monitoring Map</h5>
    <div id="map"></div>
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
        {
            name: "Colombo",
            coords: [6.9271, 79.8612],
            aqi: 27
        },
        {
            name: "Dehiwala",
            coords: [6.8506, 79.8656],
            aqi: 55
        },
        {
            name: "Kotte",
            coords: [6.8918, 79.9182],
            aqi: 102
        }
    ];

    sensors.forEach(sensor => {
        const popup = `<strong>${sensor.name}</strong><br>AQI: ${sensor.aqi}`;
        L.marker(sensor.coords).addTo(map).bindPopup(popup);
    });
</script>
@endpush

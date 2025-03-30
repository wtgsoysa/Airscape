@extends('layouts.admin')

@section('content')
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

    .data-table th {
        background-color: #f0f9f0;
        color: #003B3B;
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

    .aqi-good {
        background-color: #00E400;
        color: white;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .aqi-moderate {
        background-color: #FFFF00;
        color: #000;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
    }
    
    .aqi-sensitive {
        background-color: #FF7E00;
        color: white;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .aqi-unhealthy {
        background-color: #FF0000;
        color: white;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .aqi-verybad {
        background-color: #8F3F97;
        color: white;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .aqi-hazardous {
        background-color: #7E0023;
        color: white;
        font-weight: bold;
        padding: 4px 10px;
        border-radius: 6px;
    }
</style>

<div class="page-wrapper">
    <h4 class="section-title">Data Management</h4>

    <!-- Filters -->
    <div class="filter-bar align-items-end">
        <div>
            <label class="form-label">Location</label>
            <select class="form-select">
                <option selected>All</option>
                <option>Colombo</option>
                <option>Dehiwala</option>
                <option>Kotte</option>
                <option>Moratuwa</option>
            </select>
        </div>
        <div>
            <label class="form-label">From</label>
            <input type="datetime-local" class="form-control">
        </div>
        <div>
            <label class="form-label">To</label>
            <input type="datetime-local" class="form-control">
        </div>
        <button class="btn btn-export">Export CSV</button>
        <button class="btn btn-refresh">Refresh</button>
    </div>

    <!-- Chart -->
    <canvas id="aqiChart" height="100" class="mb-4"></canvas>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Total Records</div>
                <div class="fs-4">1502</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Average AQI</div>
                <div class="fs-4">82</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Active Sensors</div>
                <div class="fs-4">12</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Inactive Sensors</div>
                <div class="fs-4">3</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Sensor ID</th>
                    <th>Location</th>
                    <th>AQI</th>
                    <th>Status</th>
                    <th>Trend</th>
                    <th>Recorded At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $records = [
                        ['id' => '#S001', 'location' => 'Colombo', 'aqi' => 48, 'status' => 'Active', 'time' => '2025-03-30 14:21'],
                        ['id' => '#S002', 'location' => 'Dehiwala', 'aqi' => 110, 'status' => 'Inactive', 'time' => '2025-03-30 14:18'],
                        ['id' => '#S003', 'location' => 'Kotte', 'aqi' => 178, 'status' => 'Active', 'time' => '2025-03-30 14:15'],
                        ['id' => '#S004', 'location' => 'Moratuwa', 'aqi' => 300, 'status' => 'Active', 'time' => '2025-03-30 14:10']
                    ];
                @endphp

                @foreach($records as $rec)
                    @php
                        $aqi = $rec['aqi'];
                        $aqiClass = $aqi <= 50 ? 'aqi-good' :
                                    ($aqi <= 100 ? 'aqi-moderate' :
                                    ($aqi <= 150 ? 'aqi-sensitive' :
                                    ($aqi <= 200 ? 'aqi-unhealthy' :
                                    ($aqi <= 300 ? 'aqi-verybad' : 'aqi-hazardous'))));
                    @endphp
                    <tr>
                        <td>{{ $rec['id'] }}</td>
                        <td>{{ $rec['location'] }}</td>
                        <td><span class="{{ $aqiClass }}">{{ $rec['aqi'] }}</span></td>
                        <td>
                            <span class="badge {{ $rec['status'] == 'Active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $rec['status'] }}
                            </span>
                        </td>
                        <td>
                            @if($aqi < 150)
                                <i class="bi bi-graph-up text-success"></i>
                            @else
                                <i class="bi bi-graph-down text-danger"></i>
                            @endif
                        </td>
                        <td>{{ $rec['time'] }}</td>
                        <td><button class="btn btn-sm btn-outline-danger">Delete</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('aqiChart').getContext('2d');
    const aqiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['13:50', '14:00', '14:10', '14:20', '14:30'],
            datasets: [{
                label: 'Colombo AQI',
                data: [72, 85, 91, 78, 88],
                fill: false,
                borderColor: '#007872',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'AQI Value' }
                },
                x: {
                    title: { display: true, text: 'Time' }
                }
            }
        }
    });
</script>
@endpush

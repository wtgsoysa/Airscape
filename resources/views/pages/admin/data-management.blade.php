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

    .aqi-good { background-color: #00E400; color: white; }
    .aqi-moderate { background-color: #FFFF00; color: #000; }
    .aqi-sensitive { background-color: #FF7E00; color: white; }
    .aqi-unhealthy { background-color: #FF0000; color: white; }
    .aqi-verybad { background-color: #8F3F97; color: white; }
    .aqi-hazardous { background-color: #7E0023; color: white; }

    .data-table th {
        background-color: #f0f9f0;
        color: #003B3B;
    }
</style>

<div class="page-wrapper">
    <h4 class="section-title">Data Management</h4>

    <!-- Filters -->
    <form action="{{ route('admin.data-management.filter') }}" method="GET" class="filter-bar align-items-end">
        <div>
            <label class="form-label">Location</label>
            <select name="location" class="form-select">
                <option value="">All</option>
                @foreach($locations as $location)
                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                        {{ $location }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">From</label>
            <input type="datetime-local" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div>
            <label class="form-label">To</label>
            <input type="datetime-local" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <button type="submit" class="btn btn-refresh">Refresh</button>
        <a href="{{ route('admin.data-management.export') }}" class="btn btn-export">Export CSV</a>
    </form>

    <!-- Chart -->
    <canvas id="aqiChart" height="100" class="mb-4"></canvas>

    <!-- Summary -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Total Records</div>
                <div class="fs-4">{{ $total }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Average AQI</div>
                <div class="fs-4">{{ $average }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Active Sensors</div>
                <div class="fs-4">{{ $activeCount }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card">
                <div class="label">Inactive Sensors</div>
                <div class="fs-4">{{ $inactiveCount }}</div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Sensor ID</th>
                    <th>Location</th>
                    <th>AQI</th>
                    <th>Status</th>
                    <th>Recorded At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $rec)
                    @php
                        $aqiClass = $rec->aqi <= 50 ? 'aqi-good' :
                                    ($rec->aqi <= 100 ? 'aqi-moderate' :
                                    ($rec->aqi <= 150 ? 'aqi-sensitive' :
                                    ($rec->aqi <= 200 ? 'aqi-unhealthy' :
                                    ($rec->aqi <= 300 ? 'aqi-verybad' : 'aqi-hazardous'))));
                    @endphp
                    <tr>
                        <td>{{ $rec->sensor_id }}</td>
                        <td>{{ $rec->location }}</td>
                        <td><span class="{{ $aqiClass }}">{{ $rec->aqi }}</span></td>
                        <td><span class="badge {{ $rec->status === 'Active' ? 'bg-success' : 'bg-danger' }}">{{ $rec->status }}</span></td>
                        <td>{{ $rec->recorded_at }}</td>
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
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'AQI Over Time',
                data: {!! json_encode($chartValues) !!},
                borderColor: '#007872',
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } },
            scales: {
                x: { title: { display: true, text: 'Time' }},
                y: { title: { display: true, text: 'AQI' }, beginAtZero: true }
            }
        }
    });
</script>
@endpush

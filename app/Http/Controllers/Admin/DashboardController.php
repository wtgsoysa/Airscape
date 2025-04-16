<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;

class DashboardController extends Controller
{
    /**
     * Display the main admin dashboard with active sensor statuses.
     */
    public function dashboardView()
    {
        $sensors = Sensor::where('status', 'Active')
            ->orderBy('location')
            ->get(['name', 'location', 'simulated_aqi', 'last_updated']);

        return view('admin.dashboard', compact('sensors'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlertRule;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $rules = AlertRule::latest()->get();

        $recentAlerts = [
            ['message' => 'CO2 exceeded safe level', 'created_at' => now()->subMinutes(10)],
            ['message' => 'PM2.5 spike detected', 'created_at' => now()->subMinutes(25)],
            ['message' => 'Unhealthy AQI reported in Dehiwala', 'created_at' => now()->subHour()],
        ];

        return view('pages.admin.alert-configuration', compact('rules', 'recentAlerts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pollutant_type' => 'required|string',
            'threshold' => 'required|numeric|min:1',
            'check_frequency' => 'required|string',
        ]);

        AlertRule::create([
            'pollutant_type' => $request->pollutant_type,
            'threshold' => $request->threshold,
            'frequency' => $request->check_frequency,
            'email_alert' => $request->has('email_alert'),
            'system_alert' => $request->has('system_alert'),
        ]);

        return redirect()->route('alert.configuration')->with('success', 'New alert rule added successfully!');
    }

    public function destroy($id)
    {
        AlertRule::destroy($id);
        return response()->json(['message' => 'Alert rule deleted.']);
    }

    public function deleteSystemAlert($id)
    {
        DB::table('system_alerts')->where('id', $id)->delete();
        return response()->json(['message' => 'System alert removed.']);
    }

}


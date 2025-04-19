<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlertRule;
use App\Models\SystemAlert;

class AlertController extends Controller
{
    // Show alert rules and only real-time sensor alerts
    public function index()
    {
        $rules = AlertRule::latest()->get();

        // ✅ Only fetch 'sensor' type alerts for Recent System Alerts
        $recentAlerts = SystemAlert::where('type', 'sensor')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('pages.admin.alert-configuration', compact('rules', 'recentAlerts'));
    }


    // Store a new alert rule
    public function store(Request $request)
    {
        $request->validate([
            'pollutant_type' => 'required|string',
            'threshold' => 'required|numeric|min:1',
            'check_frequency' => 'required|string',
        ]);

        $rule = AlertRule::create([
            'pollutant_type' => $request->pollutant_type,
            'threshold' => $request->threshold,
            'frequency' => $request->check_frequency,
            'email_alert' => $request->has('email_alert'),
            'system_alert' => $request->has('system_alert'),
        ]);

        // ❌ Removed rule-type log creation (you don't want it shown)
        // If you ever want it again, uncomment below:
        /*
        if ($rule->system_alert) {
            SystemAlert::create([
                'message' => "{$rule->pollutant_type} threshold set at {$rule->threshold} μg/m³",
                'type' => 'rule'
            ]);
        }
        */

        return redirect()->route('alert.configuration')
                         ->with('success', 'New alert rule added successfully!');
    }

    // Delete an alert rule
    public function destroy($id)
    {
        AlertRule::destroy($id);
        return response()->json(['message' => 'Alert rule deleted.']);
    }

    // Delete a system alert (real-time alert)
    public function deleteSystemAlert($id)
    {
        $alert = SystemAlert::find($id);

        if (!$alert) {
            return response()->json(['error' => 'Alert not found.'], 404);
        }

        $alert->delete();
        return response()->json(['message' => 'System alert removed.']);
    }
}

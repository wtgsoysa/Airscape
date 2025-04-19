<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\AlertRule;
use App\Models\SystemAlert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all()->map(function ($sensor) {
            $baseline = $sensor->baseline_aqi;
            $variation = $sensor->variation;

            $min = $baseline - ($baseline * $variation / 100);
            $max = $baseline + ($baseline * $variation / 100);
            $simulated = round(mt_rand($min, $max));

            $sensor->simulated_aqi = $simulated;
            $sensor->last_updated = now()->format('Y-m-d H:i:s');

            return $sensor;
        });

        return view('pages.admin.sensors', compact('sensors'));
    }

    public function fetchLive()
    {
        return response()->json(Sensor::select([
            'name', 'location', 'status', 'latitude', 'longitude', 'simulated_aqi', 'frequency', 'variation', 'last_updated'
        ])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'location'     => 'required|string|max:255', // ✅ Correct field name
            'name'         => 'required|string|max:255',
            'sensor_id'    => 'required|string|unique:sensors',
            'status'       => 'required|in:Active,Inactive',
            'baseline_aqi' => 'required|numeric',
            'frequency'    => 'required|numeric',
            'variation'    => 'required|numeric',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
        ]);
        
        Sensor::create([
            'name'         => $request->name,
            'sensor_id'    => $request->sensor_id,
            'location'     => $request->location, // ✅ Use 'location' here
            'status'       => $request->status,
            'baseline_aqi' => $request->baseline_aqi,
            'frequency'    => $request->frequency,
            'variation'    => $request->variation,
            'latitude'     => $request->latitude,
            'longitude'    => $request->longitude,
            'current_aqi'  => $request->baseline_aqi,
            'last_updated' => now(),
        ]);
        

        return redirect()->route('admin.sensors')->with('success', 'Sensor added successfully.');
    }

    public function destroy($id)
    {
        $sensor = Sensor::findOrFail($id);
        $sensor->delete();

        return redirect()->route('admin.sensors')->with('success', 'Sensor deleted successfully.');
    }
    
    public function simulateAQI()
    {
        $sensors = \App\Models\Sensor::where('status', 'Active')->get();
        $rules = \App\Models\AlertRule::where('system_alert', true)
            ->whereRaw('LOWER(pollutant_type) = ?', ['aqi'])
            ->get();

        $now = now();

        foreach ($sensors as $sensor) {

    // ✅ TEMP: Force simulation regardless of timing
    // if ($sensor->last_updated === null || $now->diffInMinutes($sensor->last_updated) >= $sensor->frequency)
    {
        $newAQI = rand(160, 200);

        $sensor->current_aqi = $newAQI;
        $sensor->last_updated = $now;
        $sensor->save();

        foreach ($rules as $rule) {
            if ($newAQI >= $rule->threshold) {
                $message = "⚠️ AQI threshold exceeded at {$sensor->name}: {$newAQI} μg/m³ (Threshold: {$rule->threshold})";

                $alreadyExists = \App\Models\SystemAlert::where('message', $message)
                    ->where('type', 'sensor')
                    ->whereDate('created_at', $now->toDateString())
                    ->exists();

                if (!$alreadyExists) {
                   

                    \App\Models\SystemAlert::create([
                        'message' => $message,
                        'type' => 'sensor'
                    ]);
                }
            }
        }
    }
}


        echo "🌀 All sensors updated at: " . $now->format('Y-m-d H:i:s') . "<br>";
        return response()->json(['message' => 'Sensor AQI values updated and alerts checked']);
    }



    
    
    

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sensor;
use Illuminate\Support\Carbon;

class SensorController extends Controller
{
    public function index()
    {
        $sensors = Sensor::all()->map(function ($sensor) {
            // Simulation logic
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
        $sensors = Sensor::all(['name', 'location', 'status', 'latitude', 'longitude', 'simulated_aqi', 'last_updated']);
        return response()->json($sensors);
    }





    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'sensor_id'    => 'required|string|unique:sensors',
            'location'     => 'required|string|max:255',
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
            'location'     => $request->location,
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
        $sensors = Sensor::where('status', 'Active')->get();

        foreach ($sensors as $sensor) {
            $now = Carbon::now();
            if ($sensor->last_updated === null || $now->diffInMinutes($sensor->last_updated) >= $sensor->frequency) {
                $baseline = $sensor->baseline_aqi;
                $variation = $sensor->variation;

                $fluctuation = rand(-$variation, $variation);
                $newAQI = max(0, $baseline + $fluctuation);

                $sensor->current_aqi = $newAQI;
                $sensor->last_updated = $now;
                $sensor->save();
            }
        }

        return response()->json(['message' => 'Sensor AQI values updated successfully']);
    }
}

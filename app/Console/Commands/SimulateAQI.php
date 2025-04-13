<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;
use Carbon\Carbon;

class SimulateAQI extends Command
{
    protected $signature = 'simulate:aqi';
    protected $description = 'Simulates AQI values for all sensors every minute using Colombo timezone';

    public function handle(): void
    {
        // Use Sri Lanka timezone (Colombo)
        $now = Carbon::now('Asia/Colombo');

        $sensors = Sensor::all();

        foreach ($sensors as $sensor) {
            $baseline = $sensor->baseline_aqi;
            $variation = $sensor->variation;

            // Calculate variation range
            $variationRange = $baseline * ($variation / 100);

            // Random value within ±variation
            $randomVariation = rand(-$variationRange * 100, $variationRange * 100) / 100;
            $simulatedAqi = round($baseline + $randomVariation, 2);

            // Save to database
            $sensor->simulated_aqi = max(0, $simulatedAqi); // Ensure AQI not negative
            $sensor->current_aqi = $sensor->simulated_aqi;
            $sensor->last_updated = $now;
            $sensor->save();

            // Console output
            $this->info("✅ Forced update {$sensor->name} → AQI: {$sensor->simulated_aqi}");
        }

        $this->info("🌀 All sensors updated at: " . $now->toDateTimeString());
    }
}

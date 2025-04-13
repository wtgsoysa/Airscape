<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sensor;
use Carbon\Carbon;

class SimulateAQI extends Command
{
    protected $signature = 'simulate:aqi';
    protected $description = 'Simulates AQI values for all sensors based on baseline, variation, and frequency';

    public function handle(): void
    {
        $now = Carbon::now();
        $sensors = Sensor::all();

        foreach ($sensors as $sensor) {
            $lastUpdated = $sensor->last_updated ?? $now->copy()->subMinutes($sensor->frequency + 1);

            if ($sensor->frequency && $now->diffInMinutes($lastUpdated) >= $sensor->frequency) {
                $variationRange = $sensor->baseline_aqi * ($sensor->variation / 100);
                $randomVariation = rand(-$variationRange * 100, $variationRange * 100) / 100;

                $simulatedAqi = round($sensor->baseline_aqi + $randomVariation, 2);

                $sensor->simulated_aqi = max(0, $simulatedAqi);
                $sensor->current_aqi = $sensor->simulated_aqi;
                $sensor->last_updated = $now;

                $sensor->save();

                $this->info("✅ Updated {$sensor->name} → AQI: {$sensor->simulated_aqi}");
            } else {
                $this->info("⏳ Skipped {$sensor->name} → Waiting for frequency interval");
            }
        }

        $this->info('Simulation loop complete.');
    }


}

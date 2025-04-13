<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SimulateAQI::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Automatically simulate AQI every minute using timezone
        $schedule->command('simulate:aqi')
            ->everyMinute()
            ->timezone('Asia/Colombo');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}

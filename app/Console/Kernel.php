<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run Python scrapers at 6 AM
        $schedule->exec('bash ' . base_path('Scraping/run.sh'))
                ->dailyAt('06:00')
                ->appendOutputTo(storage_path('logs/scrapers.log'));
    }

   
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

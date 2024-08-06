<?php

namespace App\Console;

use App\Http\Services\PostScheduled\PostScheduledServices;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Http\Services\Proxy\ProxyServices;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:get-info-from-ip-quality-score')->everyTwoMinutes();

        $schedule->command('app:sync-domains-with-namecheap')->daily();

        $schedule->command('app:export-workiz-reports-to-google-sheet')->everyTwoHours();

        $schedule->call(function (){
            (new ProxyServices)->updateAll();
        })->daily();

        $schedule->call(function (){
            (new PostScheduledServices)->scheduler();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

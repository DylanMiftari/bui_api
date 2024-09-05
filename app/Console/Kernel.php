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
        // $schedule->command('inspire')->hourly();
        $schedule->command("player-taxes")->weeklyOn(0, "0:0"); // Sunday at 00:00
        $schedule->command("company-taxes")->weeklyOn(0, "0:30"); // Sunday at 00:30
        $schedule->command("bank-account-maintenance")->weeklyOn(0, "1:0"); // Sunday at 01:00
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

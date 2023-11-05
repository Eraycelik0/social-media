<?php

namespace App\Console;

use App\Helpers\GoogleBookApi\GoogleBookApiHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $helper = new GoogleBookApiHelper();
            $helper->getBooks_v1();
        })->dailyAt('03:00');

        $schedule->command('import:csv')->monthly();
        $schedule->command('import:movies')->monthly();
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

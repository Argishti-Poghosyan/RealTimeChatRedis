<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        Commands\DailyQuote::class,

    ];

  
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('quote:daily')->cron('15 9 */2 * *');	

    }

    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

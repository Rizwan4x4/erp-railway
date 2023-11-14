<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\HourlyUpdate::class,
        Commands\test::class,
        Commands\PullAttendance::class,
    ];
    protected function schedule(Schedule $schedule)
    {
         //$schedule->command('inspire')->hourly();
         $schedule->command('update:HrSession')->monthlyOn(21, '00:01');
         //$schedule->command('pull:attendance')->cron('15 9,10,16,20 * * *');
        $schedule->command('pull:attendance')->hourly();
//        $schedule->command('pull:attendance')->everyMinute();
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

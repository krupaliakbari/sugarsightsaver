<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('admin:clearpermission')->everyMinute();
        $schedule->command('plan:reminderplan')->everyMinute();
        
        // Automated reminder scheduling
        $schedule->command('reminders:send six-month')->dailyAt('09:00');
        $schedule->command('reminders:send three-month')->dailyAt('10:00');
        $schedule->command('reminders:send all')->weeklyOn(1, '08:00'); // Monday at 8 AM
        
        // $schedule->command('admin:clearpermission')->hourly();
        // $schedule->command('plan:reminderplan')->hourly();
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

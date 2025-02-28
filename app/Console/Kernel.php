<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\everyDay',
        'App\Console\Commands\everyMorning',
        'App\Console\Commands\everyMonth'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('everyday:update')
                ->dailyAt('18:00');

        $schedule->command('everymorning:update')
                ->dailyAt('06:00');

        // $schedule->command('everymorning:update')
        //         ->everyMinute();

        $schedule->command('everymonth:update')
                ->monthly();
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

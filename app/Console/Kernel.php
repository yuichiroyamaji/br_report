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
        Commands\MonthlyReport::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // withoutOverlappingをつけることで多重実行を防ぐので必須
        $schedule->command('command:monthlyreport')->withoutOverlapping()->monthlyOn('1', '09:00');
        // $schedule->command('command:missingreport')->withoutOverlapping()->mondays('09:00');
        $schedule->command('command:missingreport')->withoutOverlapping()->at('21:26');
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

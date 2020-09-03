<?php

namespace App\Console;

use App\Jobs\ReIndexWordsText;
use App\Jobs\ReIndexWordsUser;
use App\Jobs\ScrapeSites;
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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            ScrapeSites::withChain([
                new ReIndexWordsText,
            ])->dispatch();
        })
            ->daily();

        $schedule->job(new ReIndexWordsUser())->everyFiveMinutes();
        $schedule->command('queue:work --tries=3  --sansdaemon')->everyMinute()->withoutOverlapping();
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

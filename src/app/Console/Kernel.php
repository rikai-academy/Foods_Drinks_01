<?php

namespace App\Console;

use App\Console\Commands\SendReminderEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\MailCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        MailCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        # Send statistic to all Admin
        $schedule->command('mail:send')
            ->lastDayOfMonth(config('app.mailSendTime'))
            ->timezone(config('app.timezone'))
            ->appendOutputTo(config('app.directFileInspire'));

        # Delete rejected orders
        $schedule->command('order:destroy')
            ->lastDayOfMonth(config('app.orderDestroyTime'))
            ->timezone(config('app.timezone'))
            ->appendOutputTo(config('app.directFileInspire'));
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

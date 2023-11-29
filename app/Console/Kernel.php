<?php

namespace App\Console;

use App\UseCases\SendDailyQuoteUseCase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Date;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->call(fn() => app(SendDailyQuoteUseCase::class)->execute(Date::now()))
            ->name('Send daily quote')
            ->onOneServer()
            ->everyFifteenMinutes();
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

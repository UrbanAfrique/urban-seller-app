<?php

namespace App\Console;
use App\Console\Commands\SyncCategories;
use App\Console\Commands\SyncCountries;
use App\Console\Commands\SyncCustomCollections;
use App\Console\Commands\SyncCustomers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        SyncCategories::class,
        SyncCustomers::class,
        SyncCountries::class,
        SyncCustomCollections::class
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

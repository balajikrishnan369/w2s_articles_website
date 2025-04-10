<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Article;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Register custom Artisan commands
        \App\Console\Commands\PublishArticleScheduled::class,
    ];

    protected function schedule(Schedule $schedule)
    {
         // Run every minute to check for scheduled articles
         $schedule->command('app:publish-article-scheduled')->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

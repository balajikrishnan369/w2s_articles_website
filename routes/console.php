<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('schedule:run', function () {
    Artisan::call('app:publish-article-scheduled');
})->purpose('Run scheduled article publishing');

app(Schedule::class)->command('app:publish-article-scheduled')->everyMinute();
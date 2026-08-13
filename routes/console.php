<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Fetch new jobs twice daily at 01:00 and 13:00
Schedule::command('jobs:fetch-remote')->twiceDaily(1, 13);

// Verify existing job links daily at 02:00 AM
Schedule::command('jobs:verify-links')->dailyAt('02:00');

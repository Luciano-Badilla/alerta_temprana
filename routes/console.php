<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

app(Schedule::class)->command('reports:send-reminders')->everyTwoMinutes();

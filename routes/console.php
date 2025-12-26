<?php



use Illuminate\Support\Facades\Schedule;

Schedule::command('sales:daily-report')->dailyAt('20:00');

Schedule::command('queue:work --stop-when-empty --sleep=1 --tries=3 --timeout=90')
    ->everyMinute()
    ->withoutOverlapping();
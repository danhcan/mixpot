<?php

namespace Inovector\Mixpost;

use Illuminate\Console\Scheduling\Schedule as LaravelSchedule;

class Schedule
{
    public static function register(LaravelSchedule $schedule): void
    {
        $schedule->command('mixpost:delete-old-data')->daily();
        $schedule->command('mixpost:prune-temporary-directory')->hourly();
    }
}

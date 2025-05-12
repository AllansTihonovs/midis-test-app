<?php

use App\Console\Commands\BackupDatabase;
use Illuminate\Support\Facades\Schedule;

Schedule::command(BackupDatabase::class)->dailyAt('00:00');

<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('activate-trial-subscriptions')->everyMinute();

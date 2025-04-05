<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:cancel-old-itineraries')->everyTwoMinutes();

Schedule::command('app:cancel-old-transactions')->everyTwoMinutes();

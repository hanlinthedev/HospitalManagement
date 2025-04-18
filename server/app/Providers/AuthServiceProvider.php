<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\Schedule;
use App\Policies\RoomPolicy;
use App\Policies\SchedulePolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

     protected $policies = [
        Room::class => RoomPolicy::class,
        Schedule::class => SchedulePolicy::class,
     ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

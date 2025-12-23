<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bed;
use App\Models\Room;
use App\Models\DormitoryRecord;
use App\Models\RegisterRequest;
use App\Observers\BedObserver;
use App\Observers\RoomObserver;
use App\Observers\StudentOfficialObserver;
use App\Observers\DormitoryRecordObserver;
use App\Observers\RegisterRequestObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Bed::observe(BedObserver::class);
        Room::observe(RoomObserver::class);
        DormitoryRecord::observe(DormitoryRecordObserver::class);
        RegisterRequest::observe(RegisterRequestObserver::class);
    }
}

<?php

namespace App\Providers;

use App\Events\GoodsDeleted;
use App\Events\GoodsGroupDeleted;
use App\Events\OrderUpdated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        GoodsGroupDeleted::class => [
            \App\Listeners\GoodsGroupDeleted::class,
        ],
        GoodsDeleted::class => [
            \App\Listeners\GoodsDeleted::class,
        ],
        OrderUpdated::class => [
            \App\Listeners\OrderUpdated::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}

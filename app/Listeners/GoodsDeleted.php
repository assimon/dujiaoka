<?php

namespace App\Listeners;

use App\Models\Carmis;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\GoodsDeleted as GoodsDeletedEvent;

class GoodsDeleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(GoodsDeletedEvent $event)
    {
        Carmis::query()->where('goods_id', $event->goods->id)->delete();
    }
}

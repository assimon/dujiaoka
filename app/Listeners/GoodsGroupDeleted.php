<?php

namespace App\Listeners;

use App\Models\Goods;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\GoodsGroupDeleted as GoodsGroupDeletedEvent;

class GoodsGroupDeleted
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
     * @param  GoodsGroupDeletedEvent  $event
     * @return void
     */
    public function handle(GoodsGroupDeletedEvent $event)
    {
        Goods::query()->where('group_id', $event->goodsGroup->id)->delete();
    }
}

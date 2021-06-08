<?php

namespace App\Events;

use App\Models\GoodsGroup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GoodsGroupDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $goodsGroup;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(GoodsGroup $goodsGroup)
    {
        $this->goodsGroup = $goodsGroup;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

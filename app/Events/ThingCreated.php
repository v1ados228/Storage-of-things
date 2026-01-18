<?php

namespace App\Events;

use App\Models\Thing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThingCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Thing $thing)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('things');
    }

    public function broadcastAs(): string
    {
        return 'things.created';
    }
}

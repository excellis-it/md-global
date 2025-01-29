<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ZoomRequestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $videocall;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($videocall)
    {
        $this->videocall = $videocall;
    }

    public function broadcastWith()
    {
        return [
            'videocall' => $this->videocall,
        ];
    }

    public function broadcastAs()
    {
        return 'zoomRequest';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('zoom-request');
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRequestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $friendRequest, $friendProfilePicture;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($friendRequest, $friendProfilePicture)
    {
        $this->friendRequest = $friendRequest;
        $this->friendProfilePicture = $friendProfilePicture;
    }

    public function broadcastAs()
    {
        return 'getChatRequest';
    }

    public function broadcastWith()
    {
        return [
            'friendRequest' => $this->friendRequest,
            'friendProfilePicture' => $this->friendProfilePicture
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user-request');
    }
}

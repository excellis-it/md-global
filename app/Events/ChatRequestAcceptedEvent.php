<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRequestAcceptedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $friend, $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($friend, $chat)
    {
        $this->chat = $chat;
        $this->friend = $friend;
    }

    public function broadcastAs()
    {
        return 'getChatRequestAccepted';
    }

    public function broadcastWith()
    {
        return [
            'friend' => $this->friend,
            'chat' => $this->chat,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat-request-accepted');
    }
}

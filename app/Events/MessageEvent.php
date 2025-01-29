<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $chat, $sender_profile_picture, $reciver_profile_picture, $chat_count;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chat, $sender_profile_picture, $reciver_profile_picture, $chat_count)
    {
        $this->chat = $chat;
        $this->sender_profile_picture = $sender_profile_picture;
        $this->reciver_profile_picture = $reciver_profile_picture;
        $this->chat_count = $chat_count;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith()
     {
            return [
                'chat' => $this->chat,
                'sender_profile_picture' => $this->sender_profile_picture,
                'reciver_profile_picture' => $this->reciver_profile_picture,
                'chat_count' => $this->chat_count
            ]; 
     }

    public function broadcastAs()
    {
        return 'getChatMessage';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('broadcast-message');
    }
}

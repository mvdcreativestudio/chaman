<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $senderPhoneId;
    public $receiverPhoneId;
    public $channelName;

    public function __construct($senderPhoneId, $receiverPhoneId)
    {
        $this->senderPhoneId = $senderPhoneId;
        $this->receiverPhoneId = $receiverPhoneId;
        
        $ids = [$senderPhoneId, $receiverPhoneId];
        sort($ids);
        $this->channelName = "chat-{$ids[0]}-{$ids[1]}";
    }

    public function broadcastOn()
    {
        return new PrivateChannel('wp-chat' . $this->channelName);
    }
}

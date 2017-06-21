<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;

class FirstLogin
{
    use InteractsWithSockets, SerializesModels;

    public $file;
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($file,$type)
    {
        $this->file = $file;
        $this->type = $type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

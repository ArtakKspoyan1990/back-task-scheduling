<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaskAssigned implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $notification;


    /**
     * TaskAssigned constructor.
     * @param $notification
     */
    public function __construct($notification)
    {

        $this->notification = $notification;
    }

    /**
     * @return Channel|Channel[]|string|string[]
     */
    public function broadcastOn()
    {
        return new Channel("user.{$this->notification->user_id}");
    }


    /**
     * @return string
     */
    public function broadcastAs()
    {
        return 'task-assigned';
    }
}

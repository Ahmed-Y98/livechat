<?php

namespace App\Events;

use App\user;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class newUserRegisterd implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user;
    public $msg;
    public $id;
    public $photo;
    public function __construct($user , $msg , $id , $photo)
    {
        $this->user = $user;
        $this->msg = $msg;
        $this->id = $id;
        $this->photo = $photo;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('online-'.$this->user);
    }

    public function broadcastAs(){
        
        return 'online-user';

    }

    public function broadcastWith(){
        return [
            'message' => $this->msg,
            'username' => $this->user,
            'sender' => $this->id,
            'photo' => $this->photo
        ];
    }

  
}

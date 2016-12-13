<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Merchant;

class MerchantCreated
{
  use InteractsWithSockets, SerializesModels;

  public $merchant;

  /**
  * Create a new event instance.
  *
  * @return void
  */
  public function __construct(Merchant $merchant)
  {
    $this->merchant = $merchant;
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

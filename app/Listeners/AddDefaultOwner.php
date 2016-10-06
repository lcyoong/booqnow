<?php

namespace App\Listeners;

use App\Events\MerchantCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddDefaultOwner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MerchantCreated  $event
     * @return void
     */
    public function handle(MerchantCreated $event)
    {
        $event->merchant->users()->create(['mus_merchant' => $event->merchant->mer_id, 'mus_user' => auth()->user()->id]);
    }
}

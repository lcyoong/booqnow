<?php

namespace App\Listeners;

use App\Events\MerchantCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscribeMerchant
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
        $event->merchant->subscription()->create(['sub_plan' => 1]);
    }
}

<?php

namespace App\Listeners;

use App\Events\AddonPaxChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAddonBillItem
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
     * @param  AddonPaxChanged  $event
     * @return void
     */
    public function handle(AddonPaxChanged $event)
    {
        $addon = $event->addon;

        $bill_item = $addon->bill_item;
        
        $bill_item->update([
            'bili_unit' => $addon->add_pax,
            ]);
    }
}

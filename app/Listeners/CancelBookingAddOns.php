<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelBookingAddOns
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
     * @param  BookingCancelled  $event
     * @return void
     */
    public function handle(BookingCancelled $event)
    {
      $booking = $event->booking;

      $booking->addons()->update(['add_status' => 'cancelled']);
    }
}

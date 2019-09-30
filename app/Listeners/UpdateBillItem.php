<?php

namespace App\Listeners;

use App\Events\BookingNightChanged;

class UpdateBillItem
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
     * @param  BookingNightChanged  $event
     * @return void
     */
    public function handle(BookingNightChanged $event)
    {
        $booking = $event->booking;

        $nights = dayDiff($booking->book_from, $booking->book_to);

        $booking->room_bill_item->first()->update(['bili_unit' => $nights]);
    }
}

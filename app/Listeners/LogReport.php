<?php

namespace App\Listeners;

use App\Events\ReportCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogReport
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
     * @param  ReportCreated  $event
     * @return void
     */
    public function handle(ReportCreated $event)
    {
        $event->report->log('Handled');
    }
}

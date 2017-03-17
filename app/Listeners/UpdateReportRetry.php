<?php

namespace App\Listeners;

use App\Events\ReportFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateReportRetry
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
     * @param  ReportFailed  $event
     * @return void
     */
    public function handle(ReportFailed $event)
    {
      $event->report->update(['rep_status' => 'retry']);
    }
}

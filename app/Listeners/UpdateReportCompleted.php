<?php

namespace App\Listeners;

use App\Events\ReportCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateReportCompleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ReportCompleted  $event
     * @return void
     */
    public function handle(ReportCompleted $event)
    {
      $event->report->update(['rep_output_path' => $event->filename , 'rep_status' => 'completed']);
    }
}

<?php

namespace App\Listeners;

use App\Events\ReportRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Repositories\ReportRepository;
use App\Events\ReportCompleted;

class QueueReport implements ShouldQueue
{
  protected $repo;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReportRepository $repo)
    {
      $this->repo = $repo;
    }

    /**
     * Handle the event.
     *
     * @param  ReportRequested  $event
     * @return void
     */
    public function handle(ReportRequested $event)
    {
      $event->report->update(['rep_status' => 'inprocess']);

      $report_service = $event->report->rep_function;

      // $report = $this->app->bind('ExcelReport', "Reports\$report_service");
      $report = new ("Reports\$report_service");

      if ($report->handle()) {
        event(new ReportCompleted($event->report));
      }
    }
}

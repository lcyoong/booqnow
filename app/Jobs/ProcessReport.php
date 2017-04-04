<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\ReportCompleted;
use App\Events\ReportFailed;
use App\Report;
use Reports\ProfitLossExcel;

class ProcessReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repo;

    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $repo)
    {
      $this->repo = $repo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $this->repo->update(['rep_status' => 'inprocess']);

      $report_service = $this->repo->rep_class;

      $report = new $report_service($this->repo);

      $report->handle();

      // $report = $this->app->bind('ExcelReport', "Reports\$report_service");
      // $report = new ("Reports\$report_service");
      event(new ReportCompleted($this->repo, $report->getReportname()));
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failedx(Exception $exception)
    {
      event(new ReportFailed($exception));
    }
}

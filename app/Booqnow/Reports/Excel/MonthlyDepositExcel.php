<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\ReceiptRepository;

class MonthlyDepositExcel extends ExcelReport
{
  protected $fr_year, $to_year;

  protected $deposit_arr = [];

  public function __construct($report)
  {
    parent::__construct($report->rep_function);

    extract(unserialize($report->rep_filter));

    $this->fr_year = trim($fr_year);

    $this->to_year = trim($to_year);
  }

  /**
   * Handle report generation
   * @return void
   */
  public function handle()
  {
    Excel::create($this->reportname, function($excel) {

      $excel->sheet('Sheet1', function($sheet) {

        $this->sheet = $sheet;

        $this->setting();

        $this->header();

        $this->getData();

        $this->occupancy();

        $this->footer();

  		});
		})->store($this->ext);
  }

  /**
   * Report header
   * @return void
   */
  protected function header()
  {
    // title
    $this->sheet->getStyle("A1")->getFont()->setSize(18);

    $this->fillRow([trans('report.monthly_deposit_report_heading', ['ext' => "{$this->fr_year} to {$this->to_year}"])]);

    // Header
    $row = ['Month\Year'];

    for($year = $this->fr_year; $year <= $this->to_year; $year++) {
      $row[] = $year;
    }

    $this->fillRow($row, 1);
  }

  /**
   * Occupancy data section
   * @return void
   */
  protected function occupancy()
  {
    for ($month = 1; $month <= 12; $month++) {

      $row = [Carbon::createFromDate(null, $month, 1)->format('M')];

      for($year = $this->fr_year; $year <= $this->to_year; $year++) {

        $row[] = isset($this->deposit_arr[$year][$month]) ? $this->deposit_arr[$year][$month] : 0;

      }

      $this->fillRow($row, 0);
    }

    $row = ['Total'];

    for($year = $this->fr_year; $year <= $this->to_year; $year++) {

      $row[] = $this->sum_year[$year];

    }

    $this->fillRow($row, 0);

  }

  /**
   * Get data for report
   * @return void
   */
  protected function getData()
  {
    for($year = $this->fr_year; $year <= $this->to_year; $year++) {

      $this->sum_year[$year] = 0;

      $deposits = (new ReceiptRepository)->depositByMonth($year);

      foreach ($deposits as $deposit) {

        $this->deposit_arr[$year][$deposit->mth] = $deposit->total;

        $this->sum_year[$year] += $this->deposit_arr[$year][$deposit->mth];

      }
    }

  }

}

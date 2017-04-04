<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\ResourceRepository;

class OccupancyByRoomExcel extends ExcelReport
{
  protected $year;

  protected $occ_arr;

  public function __construct($report)
  {
    parent::__construct($report->rep_function);

    extract(unserialize($report->rep_filter));

    $this->year = trim($year);
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

    $this->fillRow([trans('report.monthly_occupancy_report_heading', ['ext' => $this->year])]);

    // Header
    $row = ['Room'];

    for ($month = 1; $month <= 12; $month++) {

      $row[] = Carbon::createFromDate(null, $month, 1)->format('M');

    }

    $row[] = 'Annual';

    $this->fillRow($row, 1);
  }

  /**
   * Occupancy data section
   * @return void
   */
  protected function occupancy()
  {
    foreach ($this->occ_arr as $room => $month_counter) {

      $row = [$room];

      for ($month = 1; $month <= 12; $month++) {

        $row[$month] = 0;

      }

      foreach ($month_counter as $month => $counter) {

        if (!empty($month)) {

          $row[$month] = $counter;

        }

      }

      $row[] = array_sum($row);

      $this->fillRow($row);
    }

    // Summary row
    $row = ['TOTAL NIGHTS'];

    for ($month = 1; $month <= 12; $month++) {

      $row[$month] = 0;

    }

    foreach ($this->occ_arr as $room => $month_counter) {

      foreach ($month_counter as $month => $counter) {

        if (isset($row[$month])) {

          $row[$month] += $counter;

        }

      }

    }

    $row[] = array_sum($row);

    $this->fillRow($row, 0);

  }

  /**
   * Get data for report
   * @return void
   */
  protected function getData()
  {
    $occupancies = (new ResourceRepository)->occupancyByRoom($this->year);

    $this->occ_arr = [];

    foreach ($occupancies as $occupancy) {

      $this->occ_arr[$occupancy->rs_name][$occupancy->mth] = $occupancy->counter;

    }

  }

}

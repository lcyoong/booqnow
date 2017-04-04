<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use App\RoomOccupancy;

class OccupancyByDayExcel extends ExcelReport
{
  protected $year;

  public function __construct($report)
  {
    parent::__construct($report->rep_function);

    extract(unserialize($report->rep_filter));

    $this->year = $year;
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

    $this->fillRow([trans('report.daily_occupancy_report_heading', ['ext' => $this->year])]);

    // Header
    $row = ['Month\Day'];

    for ($day = 1; $day <= 31; $day++) {

      $row[] = $day;

    }

    $row[] = 'Average';

    $this->fillRow($row, 1);
  }

  /**
   * Report income section
   * @return void
   */
  protected function occupancy()
  {
    for ($mth = 1; $mth <= 12; $mth++) {

      $row = [Carbon::createFromDate(null, $mth, 1)->format('M')];

      for ($day = 1; $day <= 31; $day++) {

        $row[$day] = 0;

      }

      if (isset($this->occ_arr[$mth])) {

        foreach ($this->occ_arr[$mth] as $day => $counter) {

          $row[$day] = $counter;

        }

      }

      $row[] = array_sum($row);

      $this->fillRow($row, 0);

    }
  }

  /**
   * Get the data for report
   * @return void
   */
  protected function getData()
  {
    $occupancies = (new RoomOccupancy)->byDayOfMonth($this->year);

    $this->occ_arr = [];

    foreach ($occupancies as $occupancy) {

      $this->occ_arr[$occupancy->mth][$occupancy->day] = $occupancy->counter;

    }
  }

}

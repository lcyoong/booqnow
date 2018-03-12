<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\RoomOccupancyRepository;
use Repositories\ResourceRepository;
use Log;

class OccupancyByDayExcel extends ExcelReport
{
  protected $year;

  protected $total_rooms;

  protected $occ_arr, $occ_day;

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

    $row[] = 'Total';

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

      // Percentage
      $row = ["%"];

      for ($day = 1; $day <= 31; $day++) {

        $row[$day] = 0;

      }

      if (isset($this->occ_arr[$mth])) {

        foreach ($this->occ_arr[$mth] as $day => $counter) {

          $row[$day] = number_format($counter*100/$this->total_rooms) . '%';

        }

      }

      $this->fillRow($row, 0);

    }

    // Summary
    $row = ["Total rooms occupied"];

    for ($day = 1; $day <= 31; $day++) {

      $row[$day] = array_get($this->occ_day, $day, 0);

    }

    $row[] = array_sum($row);

    $this->fillRow($row, 0);
  }

  /**
   * Get the data for report
   * @return void
   */
  protected function getData()
  {
    // $occupancies = (new RoomOccupancy)->withoutLabel(['tent'])->byDayOfMonth($this->year);
    $occupancies = (new RoomOccupancyRepository)->withoutLabel(['tent'])->byDayOfMonth($this->year);

    $this->total_rooms = (new ResourceRepository)->withoutLabel(['tent'])->countByType([1]);

    Log::info($this->total_rooms);

    $this->occ_arr = [];

    foreach ($occupancies as $occupancy) {

      $this->occ_arr[$occupancy->mth][$occupancy->day] = $occupancy->counter;

      if (array_get($this->occ_day, $occupancy->day)) {
        $this->occ_day[$occupancy->day] += $occupancy->counter;
      } else {
        $this->occ_day[$occupancy->day] = $occupancy->counter;
      }

    }
  }

}

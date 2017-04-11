<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use App\RoomOccupancy;
use Repositories\BillRepository;
use Repositories\CountryRepository;

class OccupancyByNationalExcel extends ExcelReport
{
  protected $year;

  protected $occ_arr = [];

  protected $spend_arr = [];

  protected $countries;

  public function __construct($report)
  {
    $this->countries = (new CountryRepository)->getDropDown();

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

    $this->fillRow([trans('report.national_occupancy_report_heading', ['ext' => $this->year])]);

    // Header
    $row = ['National\Month'];

    for ($month = 1; $month <= 12; $month++) {

      $row[] = Carbon::createFromDate(null, $month, 1)->format('M');

      $row[] = "";
      //
      // $col = PHPExcel_Cell::stringFromColumnIndex($month * 2);
      //
      // $colnext = PHPExcel_Cell::stringFromColumnIndex($month * 2 + 1);
      //
      // dd("$col{$this->row}:$colnext{$this->row}");
      //
      // $this->sheet->mergeCells("$col{$this->row}:$colnext{$this->row}");

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
    $total_nights = 0;

    $total_spend = 0;

    foreach ($this->occ_arr as $country => $month_counter) {

      $row = [array_get($this->countries, $country, '')];

      for ($month = 1; $month <= 12; $month++) {

        $row[$month * 2 - 1] = 0;

        $row[$month * 2] = 0;

      }

      foreach ($month_counter as $month => $counter) {

        if (!empty($month)) {

          // $row[$month] = $counter;
          $row[$month * 2 - 1] = $counter;

        }

      }

      foreach ($this->spend_arr[$country] as $month => $sum) {

        if (!empty($month)) {

          $row[$month * 2] = $sum;

        }

      }

      // $row[] = array_sum($row);
      $total_nights += array_sum($month_counter);

      $total_spend += array_sum($this->spend_arr[$country]);

      $row[] = array_sum($month_counter);

      $row[] = array_sum($this->spend_arr[$country]);

      $this->fillRow($row);
    }

    // Summary row
    $row = ['TOTAL NIGHTS'];

    for ($month = 1; $month <= 12; $month++) {

      // $row[$month] = 0;
      $row[$month * 2 - 1] = 0;
      $row[$month * 2] = 0;

    }

    foreach ($this->occ_arr as $country => $month_counter) {

      foreach ($month_counter as $month => $counter) {

        if (isset($row[$month])) {

          // $row[$month] += $counter;
          $row[$month * 2 - 1] += $counter;

          $row[$month * 2] += $this->spend_arr[$country][$month];

        }

      }

    }

    $row[] = $total_nights;

    $row[] = $total_spend;

    $this->fillRow($row, 0);

  }

  /**
   * Get data for report
   * @return void
   */
  protected function getData()
  {
    $occupancies = (new RoomOccupancy)->byNational($this->year);

    $spendings = (new BillRepository)->byMonthNational($this->year);

    foreach ($occupancies as $occupancy) {

      $this->occ_arr[$occupancy->country][$occupancy->mth] = $occupancy->counter;

    }

    foreach ($spendings as $spending) {

      $this->spend_arr[$spending->country][$spending->mth] = $spending->sum;

    }

  }

}

<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use App\RoomOccupancy;
use Repositories\BookingRepository;
use Repositories\BillRepository;

class MonthlyStatExcel extends ExcelReport
{
  protected $year;

  protected $occ_arr = [];

  protected $avg_night_arr = [];

  protected $avg_pax_arr = [];

  protected $countries;

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

    $this->fillRow([trans('report.monthly_stat_report_heading', ['ext' => $this->year])]);

    // Header
    $row = ['Metrics\Month'];

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
    $row = ['Overall occupancy'];

    foreach ($this->occ_arr as $month => $counter) {
      $row[$month] = $counter;
    }

    $this->fillRow($row, 0);

    $row = ['Average length of stay (nights)'];

    foreach ($this->avg_night_arr as $month => $night) {

      $row[$month] = $night;

    }

    $this->fillRow($row, 0);

    $row = ['Average pax per room'];

    foreach ($this->avg_pax_arr as $month => $pax) {

      $row[$month] = $pax;

    }

    $this->fillRow($row, 0);

    $row = ['Average spend per night per room'];

    $spendings = (new BillRepository)->avgSpendPerNightMonthly($this->year);

    foreach ($spendings as $spending) {

      $row[$spending->mth] = $spending->avg_gross;

    }

    $this->fillRow($row, 0);

  }

  /**
   * Get data for report
   * @return void
   */
  protected function getData()
  {
    $occupancies = (new RoomOccupancy)->byMonth($this->year);

    $nights = (new BookingRepository)->byAverageNights($this->year);

    $paxs = (new BookingRepository)->byAveragePax($this->year);

    foreach ($occupancies as $occupancy) {

      $this->occ_arr[$occupancy->mth] = $occupancy->counter;

    }

    foreach ($nights as $night) {

      $this->avg_night_arr[$night->mth] = $night->nights;

    }

    foreach ($paxs as $pax) {

      $this->avg_pax_arr[$pax->mth] = $pax->pax;

    }

    // foreach ($spendings as $spending) {
    //
    //   $this->avg_spend_arr[$spending->mth] = $spending->avg_gross;
    //
    // }

  }

}

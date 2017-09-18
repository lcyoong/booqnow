<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\ResourceRepository;
use Repositories\AddonRepository;

class MonthlyUnitsSoldExcel extends ExcelReport
{
  protected $year;

  protected $sold_arr = [];

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

        $this->output();

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

    $this->fillRow([trans('report.monthly_units_sold_report_heading', ['ext' => "{$this->year}"])]);

    // Header
    $row = ['Items'];

    for ($month = 1; $month <= 12; $month++) {

      $row[] = Carbon::createFromDate(null, $month, 1)->format('M');

    }

    $this->fillRow($row, 1);
  }

  protected function output()
  {
    $resources = (new ResourceRepository)->master()->get();

    foreach($resources as $resource) {

      $row = [$resource->rs_name];

      for ($month = 1; $month <= 12; $month++) {

        $row[$month] = 0;

      }

      if (isset($this->sold_arr[$resource->rs_id])) {

        foreach ($this->sold_arr[$resource->rs_id] as $mth => $counter) {

          $row[$mth] = $counter;

        }
        
      }

      $this->fillRow($row, 0);

    }
  }


  /**
   * Get data for report
   * @return void
   */
  protected function getData()
  {
    $list = (new AddOnRepository)->soldByMonth($this->year);

    foreach($list as $item) {
      $this->sold_arr[$item->resource][$item->mth] = $item->counter;
    }
  }

}

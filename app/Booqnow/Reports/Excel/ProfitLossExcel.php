<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\ExpenseCategoryRepository;
use Repositories\ExpenseRepository;
use Repositories\ResourceTypeRepository;
use Repositories\BillItemRepository;

class ProfitLossExcel extends ExcelReport
{
  protected $year;

  protected $resource_types;

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

        $this->income();

        $this->expenses();

        $this->profit();

        $this->cost_ratio();

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

    $this->fillRow([trans('report.pnl_report_heading', ['ext' => $this->year])]);

    // Header
    $row = [''];

    for ($month = 1; $month <= 12; $month++) {

      $row[] = Carbon::createFromDate(null, $month, 1)->format('M');

    }

    array_push($row, 'TOTAL', '% of inc');

    $this->fillRow($row);
  }

  /**
   * Report income section
   * @return void
   */
  protected function income()
  {
    $this->fillRow(['INCOME']);

    $incomes = (new BillItemRepository)->sumByMonthType($this->year);

    $inc_types = (new ResourceTypeRepository)->getDropDown('rty_id', 'rty_name');

    $inc_arr = [];

    $total_income = array_sum($incomes);

    foreach ($incomes as $income) {

      $inc_arr[$income->rty_id][$income->mth] = $income->total;

    }


    $output = [''];

    for ($month = 1; $month <= 12; $month++) {

      $sum[$month] = 0;

    }

    foreach ($inc_arr as $type => $month_amount) {

      $col = [$inc_types[$type]];

      for ($month = 1; $month <= 12; $month++) {

        $col[$month] = 0;

      }

      foreach ($month_amount as $month => $amount) {

        $sum[$month] += $col[$month] = $amount;

      }

      $col[] = array_sum($col);

      $col[] = ((array_sum($col) / $total_income) * 100) . '%';

      $this->fillRow($col);
    }


    // Summary row
    $col = ['TOTAL INCOME'];

    for ($month = 1; $month <= 12; $month++) {

      $col[$month] = $sum[$month];

    }

    $col[] = array_sum($col);

    $this->fillRow($col);

  }

  /**
   * Report expenses section
   * @return void
   */
  protected function expenses()
  {
    $this->fillRow(['EXPENSES'], 1);

    $expenses = (new ExpenseRepository)->sumByMonthCategory($this->year);

    $exp_cats = (new ExpenseCategoryRepository)->isActive()->getDropDown('exc_id', 'exc_name');

    $exp_arr = [];

    foreach ($expenses as $expense) {

      $exp_arr[$expense->exp_category][$expense->mth] = $expense->total;

    }

    $output = [''];

    for ($month = 1; $month <= 12; $month++) {

      $sum[$month] = 0;

    }

    foreach ($exp_arr as $cat => $month_amount) {

      $col = [$exp_cats[$cat]];

      for ($month = 1; $month <= 12; $month++) {

        $col[$month] = 0;

      }

      foreach ($month_amount as $month => $amount) {

        $sum[$month] += $col[$month] = $amount;

      }

      $col[] = array_sum($col);

      $this->fillRow($col);

    }

    // Summary row
    $col = ['TOTAL EXPENSES'];

    for ($month = 1; $month <= 12; $month++) {

      $col[$month] = $sum[$month];

    }

    $col[] = array_sum($col);

    $this->fillRow($col, 0);

  }

  /**
   * Report profit section
   * @return void
   */
  protected function profit()
  {
    $this->fillRow(['NET PROFIT'], 1);

    foreach ($this->resource_types as $type) {

      $col = [$type->rty_name];

      for ($month = 1; $month <= 12; $month++) {

        $col[$month] = 0;

      }

      $col[] = array_sum($col);

      $this->fillRow($col, 0);

    }

    // Summary row
    $col = ['TOTAL'];

    for ($month = 1; $month <= 12; $month++) {

      $col[$month] = 0;

    }

    $col[] = array_sum($col);

    $this->fillRow($col, 0);

  }

  /**
   * Report cost-ratio section
   * @return void
   */
  protected function cost_ratio()
  {
    $this->fillRow(['COST RATIO'], 1);

    foreach ($this->resource_types as $type) {

      $col = [$type->rty_name];

      for ($month = 1; $month <= 12; $month++) {

        $col[$month] = 0;

      }

      $col[] = array_sum($col);

      $this->fillRow($col, 0);

    }
  }

  /**
   * Get data for report
   * @return void
   */
  protected function getData()
  {
    $this->resource_types = (new ResourceTypeRepository)->get();
  }
}

<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use Repositories\ExpenseRepository;
use Repositories\CodeRepository;
use Repositories\ExpenseCategoryRepository;
use Filters\ExpenseFilter;
use Carbon\Carbon;

class ExportExpensesExcel extends ExcelReport
{
  protected $filter;

  protected $data;

  public function __construct($report)
  {
    parent::__construct($report->rep_function);

    $this->filter = array_filter(unserialize($report->rep_filter));
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

        $this->content();

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

    $this->fillRow([trans('report.export_receipts_title')]);

    $this->fillRow(['Filter : ' . implode(' , ', $this->filter)]);

    $this->fillRow(
      [
        trans('expense.exp_date'),
        trans('expense.exp_category'),
        trans('expense.exp_method'),
        trans('expense.exp_description'),
        trans('expense.exp_amount'),
        trans('expense.exp_memo'),
        trans('expense.exp_payable'),
        trans('form.created_by'),
        trans('form.created_at'),
      ], 1
    );
  }

  /**
   * Report income section
   * @return void
   */
  protected function content()
  {
    $exp_methods = (new CodeRepository)->getDropDown('exp_method', true);

    $category = (new ExpenseCategoryRepository)->getDropDown('exc_id', 'exc_name');

    foreach ($this->data as $record)
    {
      $row = [];
      $row[] = $record->exp_date;
      $row[] = $category[$record->exp_category] ?? '';
      $row[] = $exp_methods[$record->exp_method] ?? '';
      $row[] = $record->exp_description;
      $row[] = $record->exp_amount;
      $row[] = $record->exp_memo;
      $row[] = $record->exp_payable;
      $row[] = $record->creator->name;
      $row[] = $record->created_at;
      $this->fillRow($row);

    }
  }

  /**
   * Get the data for report
   * @return void
   */
  protected function getData()
  {
    $filters = new ExpenseFilter($this->filter);

    $this->data = (new ExpenseRepository)->with(['creator'])->get($filters);
  }

}

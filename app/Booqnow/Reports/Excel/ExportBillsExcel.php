<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use Repositories\BillRepository;
use Filters\BillFilter;
use Carbon\Carbon;

class ExportBillsExcel extends ExcelReport
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

    $this->fillRow([trans('report.export_bills_title')]);

    $this->fillRow(['Filter : ' . implode(' , ', $this->filter)]);

    $this->fillRow(
      [
        trans('bill.bil_id'),
        trans('bill.bil_customer'),
        trans('bill.bil_customer_name'),
        trans('bill.bil_date'),
        trans('bill.bil_gross'),
        trans('bill.bil_tax'),
        trans('bill.bil_paid'),
        trans('bill.bil_status'),
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
    foreach ($this->data as $record)
    {
      $row = [];
      $row[] = $record->bil_id;
      $row[] = $record->bil_customer;
      $row[] = $record->bil_customer_name;
      $row[] = $record->bil_date;
      $row[] = $record->bil_gross;
      $row[] = $record->bil_tax;
      $row[] = $record->bil_paid;
      $row[] = $record->bil_status;
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
    $filters = new BillFilter($this->filter);

    $this->data = (new BillRepository)->with(['creator'])->get($filters);
  }

}

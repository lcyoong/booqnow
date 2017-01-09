<?php

namespace Reports;

use App\Events\ReportCreated;
use Excel;
use Repositories\BillRepository;

class BillExportExcel extends ExcelReport
{
  /**
   * Handle report generation
   * @return void
   */
  public function handle()
  {
    Excel::create($this->reportname, function($excel) {

      $excel->sheet('Sheet1', function($sheet) {

        $this->sheet = $sheet;

        $this->header();

        $this->content();

        $this->footer();

  		});
		})->store($this->ext);

    event(new ReportCreated($this));
  }

  /**
   * Report header
   * @return void
   */
  protected function header()
  {
    $this->sheet->setHeight($this->row, 25);

    $this->fillRow(['Export Bills']);
  }

  /**
   * Report footer
   * @return void
   */
  protected function footer()
  {
    $this->fillRow(['**End of report'], 1);
  }

  protected function content()
  {
    $repo = new BillRepository;

    $bills = $repo->get($this->filters);

    $this->fillRow([
      trans('bill.bil_id'),
      trans('bill.bil_accounting'),
      trans('bill.bil_booking'),
      trans('bill.bil_description'),
      trans('bill.bil_date'),
      trans('bill.bil_gross'),
      trans('bill.bil_tax'),
      trans('bill.bil_paid'),
      trans('bill.bil_status'),
      trans('bill.created_by'),
      trans('bill.created_at'),
    ]);

    foreach ($bills as $bill)
    {
      $this->fillRow([
        $bill->bil_id,
        $bill->bil_accounting,
        $bill->bil_booking,
        $bill->bil_description,
        $bill->bil_date,
        $bill->bil_gross,
        $bill->bil_tax,
        $bill->bil_paid,
        $bill->bil_status,
        $bill->created_by,
        $bill->created_at,
      ]);
    }
  }

  public function filter($filter)
  {
    $this->filters = $filter;
  }

}

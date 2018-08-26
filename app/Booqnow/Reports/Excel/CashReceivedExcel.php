<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use Repositories\BillRepository;
use Filters\BillFilter;
use Carbon\Carbon;

class CashReceivedExcel extends ExcelReport
{
  protected $filter;

  protected $data;

  protected $type;

  protected $title;

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

    $this->fillRow([$this->title]);

    $this->fillRow(['Filter : ' . implode(' , ', $this->filter)]);

    $this->fillRow(
      [
        trans('booking.book_id'),
        trans('booking.book_to'),
        trans('booking.book_customer'),
        trans('bill.bil_id'),
        trans('bill.bil_gross'),
        trans('bill.bil_tax'),
        trans('bill.total'),
        trans('bill.outstanding'),
        trans('bill.deposit_paid'),
        trans('bill.cash_received'),
        trans('booking.book_from'),
      ], 1
    );
  }

  /**
   * Report income section
   * @return void
   */
  protected function content()
  {
    $break_date = null;

    foreach ($this->data as $record)
    {
      // $this->breakDate($break_date, $record->add_date);
      $row = [];
      $row[] = $record->book_id;
      $row[] = Carbon::parse($record->book_to)->format('d-m-Y');
      $row[] = isset($record->customer) ? $record->customer->full_name : '';
      $row[] = $record->bil_id;
      $row[] = $record->bil_gross;
      $row[] = $record->bil_tax;
      $row[] = $record->bil_gross + $record->bil_tax;
      $row[] = $record->outstanding;
      $row[] = $record->receipts()->where('rc_status', '=', 'active')->where('rc_type', '=', 'deposit')->sum('rc_amount');
      $row[] = $record->receipts()->where('rc_status', '=', 'active')->where('rc_type', '!=', 'deposit')->where('rc_method', '=', 'cash')->sum('rc_amount');
      $row[] = Carbon::parse($record->book_from)->format('d-m-Y');
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

    $this->data = (new BillRepository)->with(['customer'])->filter($filters)->cashReceived();
  }

  /**
   * Insert new row on break date
   * @param  string $date1  First date
   * @param  string $date2  Second date
   * @return void
   */
  protected function breakDate(&$date1, $date2)
  {
    if ($date1 != Carbon::parse($date2)->format('Y-m-d')) {

      $date1 = Carbon::parse($date2)->format('Y-m-d');

      $this->fillRow([]);

    }
  }
}

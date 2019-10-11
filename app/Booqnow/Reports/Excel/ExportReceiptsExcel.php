<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use Repositories\ReceiptRepository;
use Filters\ReceiptFilter;
use Carbon\Carbon;
use App\BookingSource;

class ExportReceiptsExcel extends ExcelReport
{
  protected $filter;

  protected $data;

  public function __construct($report)
  {
    parent::__construct('income_report');

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
        trans('receipt.rc_id'),
        trans('receipt.rc_bill'),
        trans('bill.bil_booking'),
        trans('booking.book_source'),
        trans('bill.bil_customer_name'),
        'Room name',
        trans('receipt.rc_date'),
        trans('receipt.rc_method'),
        trans('receipt.rc_amount'),
        trans('receipt.rc_type'),
        'Description',
        trans('receipt.rc_status'),
        trans('booking.book_status'),
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
    $sources_collection = BookingSource::get(['bs_id', 'bs_description']);

    $sources = array_column($sources_collection->toArray(), 'bs_description', 'bs_id');

    foreach ($this->data as $record)
    {
      $booking = $record->bill->bil_booking ?? '';
      $row = [];
      $row[] = $record->rc_id;
      $row[] = $record->rc_bill;
      $row[] = $booking != '' ? 'R' . $booking : '';
      $row[] = array_get($sources, $record->bill->booking->book_source ?? '');
      $row[] = $record->bill->bil_customer_name ?? '';
      $row[] = $record->bill->booking->room->rs_name ?? '';
      $row[] = $record->rc_date;
      $row[] = $record->rc_method;
      $row[] = $record->rc_amount;
      $row[] = $record->rc_type;
      $row[] = $record->rc_remark;
      $row[] = $record->rc_status;
      $row[] = $record->bill->booking->book_status ?? '';
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
    $filters = new ReceiptFilter($this->filter);

    $this->data = (new ReceiptRepository)->with(['creator', 'bill'])->get($filters);
  }

}

<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use Repositories\AddonRepository;
use Filters\AddonFilter;
use Carbon\Carbon;

class DailyAddonExcel extends ExcelReport
{
  protected $filter;

  protected $data;

  protected $type;

  protected $title;

  public function __construct($report, $type, $title)
  {
    parent::__construct($report->rep_function);

    $this->type = $type;

    $this->title = $title;

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
        trans('addon.add_date'),
        trans('addon.add_resource'),
        trans('addon.add_customer_name'),
        trans('addon.add_pax'),
        trans('addon.add_pax_child'),
        trans('addon.add_agent'),
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
      $this->breakDate($break_date, $record->add_date);
      $row = [];
      $row[] = $record->add_date;
      $row[] = $record->resource->rs_name;
      $row[] = $record->add_customer_name;
      $row[] = $record->add_pax;
      $row[] = $record->add_pax_child;
      $row[] = isset($record->agent) ? $record->agent->ag_name : '';
      $this->fillRow($row);

    }
  }

  /**
   * Get the data for report
   * @return void
   */
  protected function getData()
  {
    $filters = new AddonFilter($this->filter + ['resourceType' => $this->type]);

    $this->data = (new AddonRepository)->with(['resource', 'agent'])->get($filters, 0, ['add_date' => 'asc']);
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

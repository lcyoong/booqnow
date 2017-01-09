<?php

namespace Reports;
use Contracts\ReportInterface;
use App\Traits\ReportTrait;
use Carbon\Carbon;

abstract class ExcelReport implements ReportInterface
{
  use ReportTrait;

  protected $sheet;

  protected $ext = 'xlsx';

  protected $row = 1;

  protected $filters;

  public function __construct($reportname)
  {
    $this->reportname = $reportname;

    $this->rename();
  }

  abstract function handle();

  abstract protected function header();

  abstract protected function footer();

  /**
   * Rename the report
   * @return void
   */
  public function rename()
  {
    $this->reportname = $this->reportname  . "-" . Carbon::now()->format('YmdHis');
  }

  protected function fillRow($content, $leading_rows = 0, $indent = 0)
  {
    $this->row += $leading_rows;

    if ($indent > 0) {
      $content = array_pad($content, -1 * ($indent + count($content)), '');
    }

    $this->sheet->row($this->row, $content);

    $this->row ++;
  }
}

<?php

namespace Reports;

// use Contracts\ExcelReportInterface;
// use App\Traits\ReportTrait;
use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;

class ProfitLossExcel extends ExcelReport
{
  protected $year;

  public $filter;

  public function __construct($reportname)
  {
    parent::__construct($reportname);
  }

  /**
   * Handle report generation
   * @return void
   */
  public function handle()
  {
    extract(unserialize($this->filter));

    $this->year = $year;

    Excel::create($this->reportname, function($excel) {

      $excel->sheet('Sheet1', function($sheet) {

        $this->sheet = $sheet;

        $this->setting();

        $this->header();

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
    $this->sheet->setHeight($this->row, 25);

    $this->fillRow(['Monthly P&L']);

    $output = [''];

    for ($month = 1; $month <= 12; $month++) {
      $output[] = Carbon::parse(sprintf("{$this->year}-%s-01", $month))->format('F');
    }

    array_push($output, 'TOTAL', '% of inc');

    $this->fillRow($output);
  }

  /**
   * Report income section
   * @return void
   */
  protected function income()
  {
    $this->fillRow(['INCOME']);

    $year = trim($this->year);

    $output = [''];

    // Get bill grouped by month for the year
    $income = Bill::select(DB::raw('MONTH(bil_date) as month, SUM(bil_gross) as sum_gross'))
                    ->where('bil_status', '=', 'active')
                    ->where('bil_date', 'like', "%{$this->year}%")->groupBy(DB::raw('MONTH(bil_date)'))
                    ->get();

    $col = [];

    for ($month = 1; $month <= 12; $month++) {
      $col[$month] = 0;
    }

    foreach ($income as $monthly) {
      $col[$monthly->month] = (float) $monthly->sum_gross;
    }

    $col[] = array_sum($col);

    $this->fillRow($col, 0, 1);
  }

  /**
   * Report expenses section
   * @return void
   */
  protected function expenses()
  {
    $this->fillRow(['EXPENSES'], 1);
  }

  /**
   * Report profit section
   * @return void
   */
  protected function profit()
  {
    $this->fillRow(['NET PROFIT'], 1);
  }

  /**
   * Report cost-ratio section
   * @return void
   */
  protected function cost_ratio()
  {
    $this->fillRow(['COST RATIO'], 1);
  }

  /**
   * Report footer
   * @return void
   */
  protected function footer()
  {
    $this->fillRow(['Note: Room ratio includes Housekeeping, Bldg & repair, Equ repair'], 1);
    $this->fillRow(['Important: Jan-August does not include mgmt salaries as an expense, resulting in much higher net profit than Sept 14 onwards.']);
  }

  /**
   * Sheet setting
   * @return void
   */
  protected function setting()
  {
    $this->sheet->setStyle (
      ['font' => ['name' => 'Calibri', 'size' => 12]]
    );

    $this->sheet->setWidth('A', 35);
  }

  public function setYear($value)
  {
    $this->year = trim($value);
  }
}

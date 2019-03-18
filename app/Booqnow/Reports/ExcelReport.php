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

    abstract public function handle();

    abstract protected function header();

    /**
     * Rename the report
     * @return void
     */
    public function rename()
    {
        $this->reportname = $this->reportname  . "-" . Carbon::now()->format('YmdHis');
    }

    public function getRow()
    {
        return $this->row;
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
  

    /**
     * Report footer
     * @return void
     */
    protected function footer()
    {
        $this->fillRow([session('merchant')->mer_name], 1);

        $this->fillRow(['Generated: ' . date('d-m-Y H:i:s')]);

        $this->fillRow(['**End of report**']);
    }

    /**
     * Report sheet setting
     * @return void
     */
    protected function setting()
    {
        $this->sheet->setStyle(
      ['font' => ['name' => 'Calibri', 'size' => 12]]
    );

        $this->sheet->setWidth('A', 35);
    }
}

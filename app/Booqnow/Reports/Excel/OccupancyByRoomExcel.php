<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\ResourceRepository;

class OccupancyByRoomExcel extends ExcelReport
{
    protected $year;
    protected $total_rooms;

    protected $occ_arr;

    public function __construct($report)
    {
        parent::__construct($report->rep_function);

        extract(unserialize($report->rep_filter));

        $this->year = trim($year);
    }

    /**
     * Handle report generation
     * @return void
     */
    public function handle()
    {
        Excel::create($this->reportname, function ($excel) {
            $excel->sheet('Sheet1', function ($sheet) {
                $this->sheet = $sheet;

                $this->setting();

                $this->header();

                $this->getData();

                $this->occupancy();

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

        $this->fillRow([trans('report.monthly_occupancy_report_heading', ['ext' => $this->year])]);

        // Header
        $row = ['Room'];

        for ($month = 1; $month <= 12; $month++) {
            $row[] = Carbon::createFromDate(null, $month, 1)->format('M');
            $row[] = '%';
        }

        $row[] = 'Annual';

        $this->fillRow($row, 1);
    }

    /**
     * Occupancy data section
     * @return void
     */
    protected function occupancy()
    {
        foreach ($this->occ_arr as $room => $month_counter) {
            $row = [$room];
            $total_days = 0;

            for ($month = 1; $month <= 12; $month++) {
                $row[$month*2 - 1] = 0;
                $row[$month*2] = '0%';
            }

            foreach ($month_counter as $month => $counter) {
                if (!empty($month)) {
                    $total_days += $row[$month*2 - 1] = $counter;
                    $dt = Carbon::createFromDate($this->year, $month, 1);
                    $percent = number_format($counter / $dt->daysInMonth * 100, 1);
                    $row[$month*2] = "$percent%";
                }
            }

            // $row[] = array_sum($row);
            $row[] = $total_days;

            $this->fillRow($row);
        }

        // Summary row
        $row = ['TOTAL NIGHTS'];

        for ($month = 1; $month <= 12; $month++) {
            $row[$month*2 - 1] = 0;
            $row[$month*2] = '0%';
        }

        $total_days = 0;

        foreach ($this->occ_arr as $room => $month_counter) {
            foreach ($month_counter as $month => $counter) {
                $row[$month*2 - 1] += $counter;
                $total_days += $counter;
            }
        }

        for ($month = 1; $month <= 12; $month++) {
            $dt = Carbon::createFromDate($this->year, $month, 1);
            $percent = number_format($row[$month*2 - 1] / $dt->daysInMonth / count($this->occ_arr) * 100, 1);
            $row[$month*2] = "$percent%";
        }

        $row[] = $total_days;

        // $row[] = array_sum($row);

        $this->fillRow($row, 0);
    }

    /**
     * Get data for report
     * @return void
     */
    protected function getData()
    {
        $occupancies = (new ResourceRepository)->occupancyByRoom($this->year);

        $this->occ_arr = [];

        foreach ($occupancies as $occupancy) {
            $this->occ_arr[$occupancy->rs_name][$occupancy->mth] = $occupancy->counter;
        }
    }
}

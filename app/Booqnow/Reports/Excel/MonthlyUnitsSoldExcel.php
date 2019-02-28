<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use Carbon\Carbon;
use Repositories\ResourceRepository;
use Repositories\AddonRepository;

class MonthlyUnitsSoldExcel extends ExcelReport
{
    protected $year;

    protected $sold_arr = [];

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

                $this->output();

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

        $this->fillRow([trans('report.monthly_units_sold_report_heading', ['ext' => "{$this->year}"])]);

        // Header
        $row = ['Items'];

        for ($month = 1; $month <= 12; $month++) {
            $row[] = Carbon::createFromDate(null, $month, 1)->format('M');
        }

        $this->fillRow($row, 1);
    }

    protected function output()
    {
        $resources = (new ResourceRepository)->master()->get(null, 0, ['rs_type' => 'asc']);

        $grp_type = $grp_type_name = '';

        for ($month = 1; $month <= 12; $month++) {
            $grp_total[$month] = 0;
        }

        foreach ($resources as $resource) {
            // On group break
            if ($grp_type != $resource->rs_type) {
                // display the subtotal from previous group
                if (!empty($grp_type)) {
                    $row = ["**Subtotal - $grp_type_name"];

                    for ($month = 1; $month <= 12; $month++) {
                        $row[$month] = $grp_total[$month];
                    }

                    $this->fillRow($row, 0);
                }

                for ($month = 1; $month <= 12; $month++) {
                    $grp_total[$month] = 0;
                }

                // and the header for the new group
                $this->fillRow(["**$resource->rty_name"], 0);

                $grp_type = $resource->rs_type;

                $grp_type_name = $resource->rty_name;
            }

            // Display the resource items row - name, followed by counters by month
            $row = [$resource->rs_name];

            for ($month = 1; $month <= 12; $month++) {
                $row[$month] = 0;
            }

            if (isset($this->sold_arr[$resource->rs_id])) {
                foreach ($this->sold_arr[$resource->rs_id] as $mth => $counter) {
                    $row[$mth] = $counter;
                    $grp_total[$mth] += $counter;
                }
            }

            $this->fillRow($row, 0);
        }

        if (!empty($grp_type)) {
            $row = ["**Subtotal - $grp_type_name"];

            for ($month = 1; $month <= 12; $month++) {
                $row[$month] = $grp_total[$month];
            }

            $this->fillRow($row, 0);
        }
    }


    /**
     * Get data for report
     * @return void
     */
    protected function getData()
    {
        $list = (new AddOnRepository)->soldByMonth($this->year);

        foreach ($list as $item) {
            $this->sold_arr[$item->resource][$item->mth] = $item->counter;
        }
    }
}

<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use App\ExpenseCategory;
use Carbon\Carbon;
use Repositories\ExpenseCategoryRepository;
use Repositories\ExpenseRepository;
use Repositories\ResourceTypeRepository;
use Repositories\BillItemRepository;

class ProfitLossExcel extends ExcelReport
{
    protected $year;

    protected $resource_types;
    protected $inc_arr;
    protected $exp_arr;
    protected $np_arr;

    protected $tot_expense;
    protected $tot_income;

    public function __construct($report)
    {
        parent::__construct($report->rep_function);

        extract(unserialize($report->rep_filter));

        $this->year = $year;
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

                $this->income();

                $this->expenses();

                $this->diff_income_expense();

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
        // title
        $this->sheet->getStyle("A1")->getFont()->setSize(18);

        $this->fillRow([trans('report.pnl_report_heading', ['ext' => $this->year])]);

        // Header
        $row = [''];

        for ($month = 1; $month <= 12; $month++) {
            $row[] = Carbon::createFromDate(null, $month, 1)->format('M');
        }

        array_push($row, 'TOTAL', '% of inc');

        $this->fillRow($row);
    }

    /**
     * Report income section
     * @return void
     */
    protected function income()
    {
        $this->sheet->setColumnFormat(array(
      'B1:O100' => '#,##'
    ));

        $this->fillRow(['INCOME']);

        $this->incomes = $incomes = (new BillItemRepository)->sumByMonthType($this->year);

        $inc_types = (new ResourceTypeRepository)->getDropDown('rty_code', 'rty_name');

        $inc_arr = [];

        $total_income = 0;

        foreach ($incomes as $income) {
            $inc_arr[$income->rty_code][$income->mth] = $income->total;

            $total_income += $income->total;
        }

        $this->inc_arr = $inc_arr;


        $output = [''];

        for ($month = 1; $month <= 12; $month++) {
            $sum[$month] = 0;
        }

        foreach ($inc_arr as $type => $month_amount) {
            $col = [$inc_types[$type]];

            for ($month = 1; $month <= 12; $month++) {
                $col[$month] = 0;
            }

            foreach ($month_amount as $month => $amount) {
                $sum[$month] += $col[$month] = $amount;
            }

            $cat_sum = $col[] = array_sum($col);

            $col[] = number_format(($cat_sum / $total_income) * 100, 0) . '%';

            $this->fillRow($col);
        }


        // Summary row
        $col = ['TOTAL INCOME'];

        for ($month = 1; $month <= 12; $month++) {
            $this->tot_income[$month] = $col[$month] = $sum[$month];
        }

        $col[] = array_sum($col);

        $this->fillRow($col);
    }

    /**
     * Report expenses section
     * @return void
     */
    protected function expenses()
    {
        $this->fillRow(['EXPENSES'], 1);

        $this->expenses = $expenses = (new ExpenseRepository)->sumByMonthCategory($this->year);

        $exp_cats = (new ExpenseCategoryRepository)->isActive()->getDropDown('exc_id', 'exc_name', null, ['exc_name'=>'asc']);

        $exp_arr = [];

        foreach ($expenses as $expense) {
            $exp_arr[$expense->exp_category][$expense->mth] = $expense->total;
        }

        $this->exp_arr = $exp_arr;

        $output = [''];

        for ($month = 1; $month <= 12; $month++) {
            $sum[$month] = 0;
        }

        foreach ($exp_cats as $id => $desc) {
            if (array_get($exp_arr, $id)) {
                $col = [$desc];

                for ($month = 1; $month <= 12; $month++) {
                    $col[$month] = 0;
                }
  
                foreach ($exp_arr[$id] as $month => $amount) {
                    $sum[$month] += $col[$month] = $amount;
                }
  
                $col[] = array_sum($col);
  
                $this->fillRow($col);
            }
        }

        // foreach ($exp_arr as $cat => $month_amount) {
        //     $col = [$exp_cats[$cat]];

        //     for ($month = 1; $month <= 12; $month++) {
        //         $col[$month] = 0;
        //     }

        //     foreach ($month_amount as $month => $amount) {
        //         $sum[$month] += $col[$month] = $amount;
        //     }

        //     $col[] = array_sum($col);

        //     $this->fillRow($col);
        // }

        // Summary row
        $col = ['TOTAL EXPENSES'];

        for ($month = 1; $month <= 12; $month++) {
            $this->tot_expense[$month] = $col[$month] = $sum[$month];
        }

        $col[] = array_sum($col);

        $this->fillRow($col, 0);
    }

    /**
     * Report profit section
     * @return void
     */
    protected function profit()
    {
        $this->fillRow(['NET PROFIT'], 1);

        $ec_arr = ExpenseCategory::where('exc_label', '!=', '')->toDropDown('exc_id', 'exc_label');

        foreach ($this->resource_types as $type) {
            $col = [$type->rty_name];

            for ($month = 1; $month <= 12; $month++) {

        // Get the income for month-type
                if (isset($this->inc_arr[$type->rty_code][$month])) {
                    $col[$month] = $this->inc_arr[$type->rty_code][$month];
                } else {
                    $col[$month] = 0;
                }

                // Deduct the expenses for month-type
                foreach ($ec_arr as $id => $label) {
                    if ($type->rty_code == $label) {
                        if (isset($this->exp_arr[$id][$month])) {
                            $col[$month] -= $this->exp_arr[$id][$month];
                        }
                    }
                }

                $this->np_arr[$type->rty_code][$month] = $col[$month];

                if (isset($sum[$month])) {
                    $sum[$month] += $col[$month];
                } else {
                    $sum[$month] = $col[$month];
                }
            }

            $col[] = array_sum($col);

            $this->fillRow($col, 0);
        }

        // Summary row
        $col = ['TOTAL'];

        for ($month = 1; $month <= 12; $month++) {
            $col[$month] = $sum[$month];
        }

        $col[] = array_sum($col);

        $this->fillRow($col, 0);
    }

    /**
     * Total income - expenses section
     * @return void
     */
    protected function diff_income_expense()
    {
        $col = ['TOTAL INCOME - EXPENSES'];

        for ($month = 1; $month <= 12; $month++) {
            $col[] = $this->tot_income[$month] - $this->tot_expense[$month];
        }

        $col[] = array_sum($col);

        $this->fillRow($col, 1);
    }

    /**
     * Report cost-ratio section
     * @return void
     */
    protected function cost_ratio()
    {
        $this->fillRow(['COST RATIO'], 1);

        $ec_arr = ExpenseCategory::where('exc_label', '!=', '')->toDropDown('exc_id', 'exc_label');

        // Overall profit margin
        $col = ['Overall profit margin'];

        for ($month = 1; $month <= 12; $month++) {
            $col[$month] = round($this->tot_income[$month] != 0 ? (($this->tot_income[$month] - $this->tot_expense[$month]) / $this->tot_income[$month])*100 : 0) . '%';
        }

        $this->fillRow($col, 0);


        foreach ($this->resource_types as $type) {
            $col = [$type->rty_name];

            for ($month = 1; $month <= 12; $month++) {

        // Get the income for month-type
                $profit = isset($this->np_arr[$type->rty_code][$month]) ? $this->np_arr[$type->rty_code][$month] : 0;

                $income = isset($this->inc_arr[$type->rty_code][$month]) ? $this->inc_arr[$type->rty_code][$month] : 0;

                // Deduct the expenses for month-type
                $cost = 0;

                foreach ($ec_arr as $id => $label) {
                    if ($type->rty_code == $label) {
                        if (isset($this->exp_arr[$id][$month])) {
                            $cost += $this->exp_arr[$id][$month];
                        }
                    }
                }

                $col[$month] = (($income != 0) ? round(($cost / $income) * 100) : 0) . '%';
            }

            // $col[] = array_sum($col);

            $this->fillRow($col, 0);
        }
    }

    /**
     * Get data for report
     * @return void
     */
    protected function getData()
    {
        $this->resource_types = (new ResourceTypeRepository)->get();
    }
}

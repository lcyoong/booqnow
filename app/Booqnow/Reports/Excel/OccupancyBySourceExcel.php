<?php

namespace Reports;

use App\Events\ReportCreated;
use DB;
use Excel;
use App\Bill;
use App\BillItem;
use Carbon\Carbon;
use Repositories\ResourceRepository;
use Repositories\BookingSourceRepository;
use App\RoomOccupancy;

class OccupancyBySourceExcel extends ExcelReport
{
    protected $year;
    protected $total_rooms;
    protected $occ_arr;
    protected $sources;

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

        $this->fillRow([trans('report.source_occupancy_report_heading', ['ext' => $this->year])]);

        // Header
        $row = ['Source'];

        for ($month = 1; $month <= 12; $month++) {
            $row[] = Carbon::createFromDate(null, $month, 1)->format('M');
            // $row[] = '%';
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
        $this->sheet->setColumnFormat(array(
            'B1:O100' => '#,##'
        ));
      
        foreach ($this->occ_arr as $source => $month_counter) {
            $this->sheet->row($this->getRow(), function ($row) {

                // call cell manipulation methods
                $row->setBackground('#dddddd');
            });

            $row = [array_get($this->sources, $source)];

            $total_days = 0;

            for ($month = 1; $month <= 12; $month++) {
                $row[$month*2 - 1] = 0;
                // $row[$month*2] = '0%';
            }

            foreach ($month_counter as $month => $counter) {
                if (!empty($month)) {
                    $total_days += $row[$month*2 - 1] = $counter;
                    // $dt = Carbon::createFromDate($this->year, $month, 1);
                    // $percent = number_format($counter / $dt->daysInMonth * 100, 1);
                    // $row[$month*2] = "$percent%";
                }
            }

            // $row[] = array_sum($row);
            $row[] = $total_days;

            $this->fillRow($row);

            // Show spending
            $spending = $this->getSpending($source);

            foreach ($spending as $type => $spend_counter) {
                $sub_row = [ucfirst($type)];

                $sum_spending = 0;

                for ($month = 1; $month <= 12; $month++) {
                    $sub_row[$month*2 - 1] = 0;
                }

                foreach ($spend_counter as $month => $counter) {
                    if (!empty($month)) {
                        $sum_spending += $sub_row[$month*2 - 1] = $counter;
                    }
                }
    
                $sub_row[] = $sum_spending;
    
                $this->fillRow($sub_row);
            }
        }

        // Summary row
        $row = ['TOTAL NIGHTS'];

        for ($month = 1; $month <= 12; $month++) {
            $row[$month*2 - 1] = 0;
            // $row[$month*2] = '0%';
        }

        $total_days = 0;

        foreach ($this->occ_arr as $source => $month_counter) {
            foreach ($month_counter as $month => $counter) {
                $row[$month*2 - 1] += $counter;
                $total_days += $counter;
            }
        }

        for ($month = 1; $month <= 12; $month++) {
            $dt = Carbon::createFromDate($this->year, $month, 1);
            $percent = number_format($row[$month*2 - 1] / $dt->daysInMonth / count($this->occ_arr) * 100, 1);
            // $row[$month*2] = "$percent%";
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
        // $occupancies = (new ResourceRepository)->occupancyByRoom($this->year);
        $this->sources = (new BookingSourceRepository)->getDropDown('bs_id', 'bs_description');

        $occupancies = RoomOccupancy::select(DB::raw("book_source, month(ro_date) as mth, count(*) as counter"))
                        ->join('resources', 'ro_room', '=', 'rs_id')
                        ->join('bookings', 'book_id', '=', 'ro_booking')
                        // ->join('booking_sources', 'bs_id', '=', 'book_source')
                        ->whereNotIn('rs_label', ['tent', 'bed', 'free'])
                        ->where('rs_type', '=', 1)->whereRaw("year(ro_date) = {$this->year}")
                        ->whereIn('book_status', ['checkedin', 'checkedout','confirmed'])
                        ->groupBy(DB::raw("book_source, month(ro_date)"))->get();


        $this->occ_arr = [];

        foreach ($occupancies as $occupancy) {
            $this->occ_arr[$occupancy->book_source][$occupancy->mth] = $occupancy->counter;
        }
    }

    private function getSpending($source)
    {
        $spendings = BillItem::select(DB::raw("rty_code, month(bil_date) as mth, sum(bili_gross) as total"))
                        ->join('bills', 'bil_id', '=', 'bili_bill')
                        ->join('resources', 'rs_id', '=', 'bili_resource')
                        ->join('resource_types', 'rty_id', '=', 'rs_type')
                        ->join('bookings', 'book_id', '=', 'bil_booking')
                        ->where('bili_active', '=', 1)
                        ->where('book_source', '=', $source)
                        ->where('bil_status', '=', 'active')
                        ->where(function ($query) {
                            $query->whereNotIn('book_status', ['cancelled', 'hold'])->orWhereNull('book_status');
                        })
                        ->whereYear('bil_date', $this->year)
                        ->groupBy(DB::raw("rty_code, month(bil_date)"))->get();
        
        $spend_arr = [];

        foreach ($spendings as $spending) {
            $spend_arr[$spending->rty_code][$spending->mth] = $spending->total;
        }

        return $spend_arr;
    }
}

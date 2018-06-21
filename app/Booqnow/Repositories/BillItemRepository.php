<?php

namespace Repositories;

use Illuminate\Http\Request;

use DB;

class BillItemRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\BillItem');

    $this->rules = [
      'bili_bill' => 'required|exists:bills,bil_id',
      'bili_resource' => 'sometimes|exists:resources,rs_id',
      'bili_unit' => 'required|numeric|min:1',
      'bili_unit_price' => 'numeric|not_in:0',
      // 'bili_gross' => 'sometimes|numeric|min:0',
      // 'bili_tax' => 'sometimes|numeric|min:0',
    ];
  }

  public function sumByMonthType($year)
  {
    return $this->repo->select(DB::raw("rty_code, month(bil_date) as mth, sum(bili_gross) as total"))
                ->join('bills', 'bil_id', '=', 'bili_bill')
                ->join('resources', 'rs_id', '=', 'bili_resource')
                ->join('resource_types', 'rty_id', '=', 'rs_type')
                ->leftJoin('bookings', 'book_id', '=', 'bil_booking')
                ->where('bili_active', '=', 1)
                ->where('bil_status', '=', 'active')
                ->where(function ($query) {
                  $query->whereNotIn('book_status', ['cancelled', 'hold'])->orWhereNull('book_status');
                })
                ->whereYear('bil_date', $year)
                ->groupBy(DB::raw("rty_code, month(bil_date)"))->get();
  }

  /**
   * Monthly sum of bill items value of the year
   * @param  [type] $year [description]
   * @return [type]       [description]
   */
  public function sumConfirmedByMonth($year)
  {
    return $this->repo->select(DB::raw("month(bil_date) as mth, sum(bili_gross) as total"))
                ->join('bills', 'bil_id', '=', 'bili_bill')
                ->join('resources', 'rs_id', '=', 'bili_resource')
                ->join('resource_types', 'rty_id', '=', 'rs_type')
                ->leftJoin('bookings', 'book_id', '=', 'bil_booking')
                ->where('bili_active', '=', 1)
                ->where('bil_status', '=', 'active')
                ->where(function ($query) {
                  $query->whereNotIn('book_status', ['cancelled', 'hold'])->orWhereNull('book_status');
                })
                ->whereYear('bil_date', $year)
                ->groupBy(DB::raw("month(bil_date)"))->get();
  }

}

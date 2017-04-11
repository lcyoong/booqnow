<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\BillFilter;
use DB;

class BillRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Bill');

    $this->filter = new BillFilter();

    // $this->withs = ['customer'];

    $this->rules = [
      // 'bil_accounting' => 'required|exists:accounting,acc_id',
      'bil_customer' => 'sometimes|exists:customers,cus_id',
      'bil_customer_name' => 'required',
      'bil_booking' => 'sometimes|exists:bookings,book_id',
      'bil_date' => 'required|date',
      'bil_due_date' => 'sometimes|date',
      'bil_gross' => 'sometimes|numeric|min:0',
      'bil_tax' => 'sometimes|numeric|min:0',
    ];
  }

  public function byMonthNational($year)
  {
    return $this->repo->select(DB::raw("cus_country as country, month(bil_date) as mth, sum(bil_gross) as sum"))
                ->join('customers', 'cus_id', '=', 'bil_customer')
                ->where('bil_status', '=', 'active')
                ->groupBy(DB::raw("cus_country, month(bil_date)"))->get();
  }

  public function avgSpendPerNightMonthly($year)
  {
    return $this->repo->select(DB::raw("month(bil_date) as mth, avg(bil_gross/datediff(book_to, book_from)) as avg_gross"))
                ->join('bookings', 'book_id', '=', 'bil_booking')
                ->where('bil_status', '=', 'active')
                ->where('book_status', '!=', 'cancelled')
                ->whereRaw("year(bil_date) = $year")
                ->groupBy(DB::raw("month(bil_date)"))->get();
  }

}

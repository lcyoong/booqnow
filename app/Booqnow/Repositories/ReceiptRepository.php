<?php

namespace Repositories;

use Filters\ReceiptFilter;
use DB;

class ReceiptRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Receipt');

    $this->filter = new ReceiptFilter();

    $this->rules = [
      // 'rc_customer' => 'required|exists:customers,cus_id',
      'rc_bill' => 'required|exists:bills,bil_id',
      'rc_date' => 'required|date',
      'rc_amount' => 'required|numeric|min:0',
      'rc_method' => 'required',
      'rc_type' => 'required',
    ];
  }

  public function depositByMonth($year)
  {
    $this->status('active')->ofType(['deposit'])->ofYear($year);

    return $this->repo->select(DB::raw("month(rc_date) as mth, sum(rc_amount) as total"))
                ->filter($this->filter)
                ->groupBy(DB::raw("month(rc_date)"))->get();
  }

}

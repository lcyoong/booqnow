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
}

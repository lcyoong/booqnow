<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\BillFilter;
use DB;

class BillRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Bill');

    $this->filter = new BillFilter();

    $this->rules = [
      // 'bil_accounting' => 'required|exists:accounting,acc_id',
      'bil_customer' => 'required|exists:customers,cus_id',
      'bil_booking' => 'required|exists:bookings,book_id',
      'bil_date' => 'required|date',
      'bil_due_date' => 'required|date',
      'bil_gross' => 'sometimes|numeric|min:0',
      'bil_tax' => 'sometimes|numeric|min:0',
    ];
  }

  // public function single($id)
  // {
  //   return $this->repo->with('customer')->find($id);
  // }

}

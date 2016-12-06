<?php

namespace Repositories;

use Illuminate\Http\Request;
use App\Customer;
use DB;

class AddonRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Addon');

    $this->rules = [
      'add_booking' => 'required|exists:bookings,book_id',
      'add_resource' => 'required|exists:resources,rs_id',
      'add_bill' => 'required|exists:bills,bil_id',
      'add_customer' => 'required|exists:customers,cus_id',
      'add_date' => 'required|date',
      'add_pax' => 'required|min:1|numeric',
      'add_unit' => 'required|min:1|numeric',
      'add_reference' => 'max:255',
      'add_tracking' => 'max:255',
    ];
  }

  public function byDate($date, $type, $limit = 5)
  {
    return $this->repo->where('add_date', '=', $date)->join('resources', 'rs_id', '=', 'add_resource')->where('rs_type', '=', $type)->limit($limit);
  }

}

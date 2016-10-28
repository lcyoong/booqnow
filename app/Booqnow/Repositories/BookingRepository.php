<?php

namespace Repositories;

use Illuminate\Http\Request;
use App\Customer;
use DB;

class BookingRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Booking');

    $this->rules = [
      'book_pax' => 'required|min:1|numeric',
      'book_reference' => 'max:255',
      'book_tracking' => 'max:255',
    ];
  }

  public function getWith($filters, $limit = 0)
  {
    return $this->get($filters, $limit, ['customer', 'resource']);
  }

  // public function store($input)
  // {
  //   DB::transaction(function () {
  //
  //     $this->store($input);
  //
  //     (new BillRepository)->store([
  //       'bil_customer' => array_get($input, 'book_customer'),
  //       'bil_booking' => $new_booking->book_id,
  //       'bil_date' => date('Y-m-d'),
  //       'bil_due_date' => date('Y-m-d'),
  //     ]);
  //   });
  // }

  public function single($id)
  {
    return $this->repo->with('customer', 'resource')->find($id);
  }

  public function overlap($resource, $from, $to)
  {
    return $this->repo->where('book_resource', '=', $resource)->where('book_to', '>', $from)->where('book_from', '<', $to);
  }

}

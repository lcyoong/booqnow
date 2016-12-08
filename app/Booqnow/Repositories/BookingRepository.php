<?php

namespace Repositories;

use Illuminate\Http\Request;
// use App\Customer;
use Filters\BookingFilter;
use DB;

class BookingRepository extends BaseRepository
{

  public function __construct()
  {
    parent::__construct('App\Booking');

    $this->filter = new BookingFilter();

    $this->rules = [
      'book_resource' => 'required|exists:resources,rs_id',
      'book_customer' => 'required|exists:customers,cus_id',
      'book_source' => 'required|exists:booking_sources,bs_id',
      'book_from' => 'required|date',
      'book_to' => 'required|date',
      'book_pax' => 'required|min:1|numeric',
      'book_reference' => 'max:255',
      'book_tracking' => 'max:255',
    ];
  }

  public function overlap($resource, $from, $to)
  {
    return $this->repo->where('book_resource', '=', $resource)->where('book_to', '>', $from)->where('book_from', '<', $to);
  }

  public function ofArrivalDate($date, $limit = 5)
  {
    $this->filter->add(['onStart' => $date]);

    return $this;
  }

  public function ofDepartureDate($date, $limit = 5)
  {
    $this->filter->add(['onEnd' => $date]);

    return $this;
  }

}

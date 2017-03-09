<?php

namespace Repositories;

use Illuminate\Http\Request;
// use App\Customer;
use Filters\BookingFilter;
use DB;

class BookingRepository extends BaseRepository
{
  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Booking');

    $this->filter = new BookingFilter();

    $this->rules = [
      'book_resource' => 'required|exists:resources,rs_id|overlap_booking:book_from,book_to,book_id|overlap_maintenance:book_from,book_to',
      'book_customer' => 'required|exists:customers,cus_id',
      'book_source' => 'required|exists:booking_sources,bs_id',
      'book_from' => 'required|date|before:book_to',
      'book_to' => 'required|date',
      'book_pax' => 'required|min:1|numeric',
      'book_reference' => 'max:255',
      'book_tracking' => 'max:255',
    ];
  }

  // public function overlap($resource, $from, $to)
  // {
  //   return $this->repo->where('book_resource', '=', $resource)->where('book_to', '>', $from)->where('book_from', '<', $to);
  // }

  /**
   * Add booking arrival date filter
   * @param  string $date - Date string
   * @return Repository
   */
  public function ofArrivalDate($date)
  {
    $this->filter->add(['onStart' => $date]);

    return $this;
  }

  /**
   * Add booking departure date filter
   * @param  string $date - Date string
   * @return Repository
   */
  public function ofDepartureDate($date)
  {
    $this->filter->add(['onEnd' => $date]);

    return $this;
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class RoomOccupancy extends TenantModel
{
  protected $primaryKey = 'ro_id';

  protected $fillable = ['ro_room', 'ro_date', 'ro_booking', 'created_by'];

  /**
   * Process occupancy tagging
   * @param  integer  $book_id      Booking id
   * @param  array    $before       Booking model values before operation
   * @param  array    $after        Booking model values after operation
   */
  public function process($book_id, $before, $after)
  {
    $this->untag($book_id);

    if ($after['book_status'] != 'cancelled') {

      $this->tag($book_id, $after['book_resource'], $after['book_from'], $after['book_to']);

    }
  }

  /**
   * Remove occupancy tag (record)
   * @param  integer $book_id     Booking id
   */
  public function untag($book_id)
  {
    $this->where('ro_booking', '=', $book_id)->delete();
  }

  /**
   * Add occupancy tag (record)
   * @param  integer  $book_id      Booking id
   * @param  integer  $room         Booking room id
   * @param  string   $from         Booking from date
   * @param  string   $to           Booking to date
   */
  public function tag($book_id, $room, $from, $to)
  {
    $start_date = Carbon::parse($from);

    $end_date = Carbon::parse($to);

    for ($date = $start_date; $date->lt($end_date); $date->addDay()) {

      $this->create(['ro_room' => $room, 'ro_booking' => $book_id, 'ro_date' => $date->format('Y-m-d')]);

    }
  }

  public function byDayOfMonth($year)
  {
    return $this->select(DB::raw("month(ro_date) as mth, day(ro_date) as day, count(*) as counter"))
                ->groupBy(DB::raw("month(ro_date), day(ro_date)"))->get();
  }

  public function byNational($year)
  {
    return $this->select(DB::raw("month(ro_date) as mth, cus_country as country, count(*) as counter"))
                ->join('bookings', 'book_id', '=', 'ro_booking')
                ->join('customers', 'cus_id', '=', 'book_customer')
                ->groupBy(DB::raw("month(ro_date), cus_country"))->get();
  }

  public function byMonth($year)
  {
    return $this->select(DB::raw("month(ro_date) as mth, count(*) as counter"))
                ->whereRaw("year(ro_date) = $year")
                ->groupBy(DB::raw("month(ro_date)"))->get();
  }
}

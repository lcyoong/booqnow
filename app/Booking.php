<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends TenantModel
{
  protected $primaryKey = 'book_id';

  protected $fillable = ['book_resource', 'book_customer', 'book_from', 'book_to', 'book_status', 'book_checkin', 'book_checkout', 'book_reference', 'book_tracking', 'book_pax', 'book_source', 'created_by'];

  /**
   * Get the customer of the booking
   * @return Collection
   */
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'book_customer');
  }

  /**
   * Get the resource of the booking
   * @return Collection
   */
  public function resource()
  {
    return $this->belongsTo(Resource::class, 'book_resource');
  }

  /**
   * Get the bills of the booking
   * @return Collection
   */
  public function bills()
  {
    return $this->hasMany(Bill::class, 'bil_booking');
  }

  /**
   * Get the addons of the booking
   * @return Collection
   */
  public function addons()
  {
    return $this->hasMany(Addon::class, 'add_booking');
  }

  /**
   * Get the booking total bill outstanding amount
   * @return numeric
   */
  public function totalBillOS()
  {
    return $this->bills->sum('outstanding');
  }

  // public function scopeOfArrivalDate($query, $date)
  // {
  //   return $query->where('book_from', '=', $date);
  // }
  //
  // public function scopeOfDepartureDate($query, $date)
  // {
  //   return $query->where('book_to', '=', $date);
  // }

  /**
   * Check in the booking
   * @return void
   */
  public function checkIn()
  {
    $this->update(['book_status' => 'checkedin']);
  }

  /**
   * Check out the booking
   * @return void
   */
  public function checkOut()
  {
    $this->update(['book_status' => 'checkedout']);
  }

}

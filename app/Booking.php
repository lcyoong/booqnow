<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends TenantModel
{
  protected $primaryKey = 'book_id';

  protected $fillable = ['book_resource', 'book_customer', 'book_from', 'book_to', 'book_status', 'book_checkin', 'book_checkout', 'book_reference', 'book_tracking', 'book_pax', 'book_source', 'created_by'];

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'book_customer');
  }

  public function resource()
  {
    return $this->belongsTo(Resource::class, 'book_resource');
  }

  public function bills()
  {
    return $this->hasMany(Bill::class, 'bil_booking');
  }

  public function addons()
  {
    return $this->hasMany(Addon::class, 'add_booking');
  }

  public function totalBillOS()
  {
    return $this->bills->sum('outstanding');
  }
}

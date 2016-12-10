<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Addon extends TenantModel
{
  protected $primaryKey = 'add_id';

  protected $fillable = ['add_booking', 'add_bill', 'add_resource', 'add_customer', 'add_date', 'add_status', 'add_reference', 'add_tracking', 'add_pax', 'add_unit', 'created_by'];

  public function setAddDateAttribute($value)
  {
      $this->attributes['add_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  public function booking()
  {
    return $this->belongsTo(Booking::class, 'add_booking');
  }

  public function resource()
  {
    return $this->belongsTo(Resource::class, 'add_resource');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'add_customer');
  }

  // public function scopeOfType($query, $rtype)
  // {
  //   return $query->join('resources', 'rs_id', '=', 'add_resource')->where('rs_type', '=', $rtype);
  // }
  //
  // public function scopeOfDate($query, $date)
  // {
  //   return $query->where('add_date', '=', $date);
  // }

}

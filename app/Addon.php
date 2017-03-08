<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use Carbon\Carbon;

class Addon extends TenantModel
{
  use AuditTrailRelationship;
  
  protected $audit = true;

  protected $primaryKey = 'add_id';

  protected $fillable = ['add_booking', 'add_bill', 'add_resource', 'add_customer', 'add_date', 'add_status', 'add_reference', 'add_tracking', 'add_pax', 'add_unit', 'created_by'];

  /**
   * Mutator to set the addon date
   * @param void
   */
  public function setAddDateAttribute($value)
  {
      $this->attributes['add_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Get the booking of the addon
   */
  public function booking()
  {
    return $this->belongsTo(Booking::class, 'add_booking');
  }

  /**
   * Get the resource of the addon
   */
  public function resource()
  {
    return $this->belongsTo(Resource::class, 'add_resource');
  }

  /**
   * Get the customer of the addon
   */
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'add_customer');
  }

}

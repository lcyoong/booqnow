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

  protected $fillable = ['add_booking', 'add_agent', 'add_bill_item', 'add_resource', 'add_customer', 'add_customer_name', 'add_date', 'add_status', 'add_reference', 'add_tracking', 'add_pax', 'add_unit', 'created_by'];

  /**
   * Mutator to set the addon date
   * @param void
   */
  public function setAddDateAttribute($value)
  {
      $this->attributes['add_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Accessor to addon date
   * @return numeric
   */
  public function getAddDateAttribute($value)
  {
    return Carbon::parse($value)->format('d-m-Y');
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

  /**
   * Get the agent of the booking
   * @return Collection
   */
  public function agent()
  {
    return $this->belongsTo(Agent::class, 'add_agent');
  }

  /**
   * Get bill item of the addon
   */
  public function bill_item()
  {
    return $this->belongsTo(BillItem::class, 'add_bill_item');
  }

  /**
   * Mutator to set the agent field
   * @param string $value
   */
  public function setAddAgentAttribute($value)
  {
    $this->attributes['add_agent'] = empty($value) ? null : $value;
  }

}

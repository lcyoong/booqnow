<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;

class Bill extends TenantModel
{
  use AuditTrailRelationship;
  protected $audit = true;

  protected $primaryKey = 'bil_id';

  protected $fillable = ['bil_accounting', 'bil_customer', 'bil_booking', 'bil_description', 'bil_date', 'bil_due_date', 'bil_gross', 'bil_tax', 'bil_status', 'created_by'];

  protected $appends = ['total_amount', 'outstanding'];

  /**
   * Accessor to get the outstanding amount for the bill
   * @return numeric
   */
  public function getOutstandingAttribute($value)
  {
    return $this->bil_gross + $this->bil_tax - $this->bil_paid;
  }

  /**
   * Accessor to get the total bill amount
   * @return numeric
   */
  public function getTotalAmountAttribute($value)
  {
    return $this->bil_gross + $this->bil_tax;
  }

  /**
   * Get the items of the bill
   */
  public function items()
  {
    return $this->hasMany(BillItem::class, 'bili_bill');
  }

  /**
   * Get the receipts of the bill
   */
  public function receipts()
  {
    return $this->hasMany(Receipt::class, 'rc_bill');
  }

  /**
   * Get the customer of the bill
   */
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'bil_customer');
  }

  /**
   * Get the booking of the bill
   */
  public function booking()
  {
    return $this->belongsTo(Booking::class, 'bil_booking');
  }

  /**
   * The comments belonging to the bill
   */
  public function comments()
  {
    return $this->hasMany(Comment::class, 'com_model_id')->where('com_model', '=', get_class($this));
  }

  /**
   * Update the bill's gross and tax amount based on the relevant bill items
   * @return void
   */
  public function refreshGrossTax()
  {
    $this->bil_gross = $this->items->sum('bili_gross');

    $this->bil_tax = $this->items->sum('bili_tax');

    $this->save();
  }

  /**
   * Update the bill's paid amount based on relevant receipts
   * @return void
   */
  public function refreshPaid()
  {
    $this->bil_paid = $this->receipts->sum('rc_amount');

    $this->save();
  }

  /**
   * Get the items of the bill with the resource details
   * @return Collection
   */
  public function getItems()
  {
    return $this->items()->join('resources', 'rs_id', 'bili_resource')->orderBy('rs_type')->get();
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;
use Carbon\Carbon;

class Bill extends TenantModel
{
  use AuditTrailRelationship;
  use CommentRelationship;
  protected $audit = true;

  protected $primaryKey = 'bil_id';

  protected $fillable = ['bil_accounting', 'bil_customer', 'bil_customer_name', 'bil_booking', 'bil_description', 'bil_date', 'bil_due_date', 'bil_gross', 'bil_tax', 'bil_status', 'bil_with_tax', 'created_by'];

  protected $appends = ['total_amount', 'outstanding', 'display_id'];

  /**
   * Mutator to set the formatted receipt date
   * @param string $value
   */
  public function setBilDateAttribute($value)
  {
      $this->attributes['bil_date'] = Carbon::parse($value)->format('Y-m-d');
  }

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
   * Accessor to bill date
   * @return numeric
   */
  public function getBilDateAttribute($value)
  {
    return Carbon::parse($value)->format('d-m-Y');
  }

  /**
   * Accessor to display id
   * @return string
   */
  public function getDisplayIdAttribute()
  {
    return "B" . $this->bil_id;
  }

  /**
   * Get the items of the bill
   */
  public function items()
  {
    return $this->hasMany(BillItem::class, 'bili_bill')->active();
  }

  /**
   * Get all items of the bill
   */
  public function allitems()
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

  public function deposit()
  {
    return $this->receipts()->where('rc_type', '=', 'deposit')->where('rc_status', '=', 'active')->sum('rc_amount');
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
    $this->bil_gross = $this->items->where('bili_active', '=', 1)->sum('bili_gross');

    $this->bil_tax = $this->items->where('bili_active', '=', 1)->sum('bili_tax');

    $this->save();
  }

  /**
   * Update the bill's paid amount based on relevant receipts
   * @return void
   */
  public function refreshPaid()
  {
    $this->bil_paid = $this->receipts()->where('rc_status', '=', 'active')->sum('rc_amount');

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

  public function getRoomItems()
  {
    return $this->items()->active()->join('resources', 'rs_id', 'bili_resource')->where('rs_type', '=', 1)->orderBy('rs_type')->get();
  }

  public function getAddonItems()
  {
    return $this->items()->active()->join('resources', 'rs_id', 'bili_resource')->where('rs_type', '!=', 1)->orderBy('bili_id', 'desc')->get(['resources.*', 'bill_items.*']);
  }

  /**
   * Get the independent items of the bill
   * @return Collection
   */
  public function indieItems()
  {
    return $this->items()->whereNull('bili_resource')->get();
  }

  public function joinWithResources()
  {
    return $this->join('resources', 'rs_id', 'bili_resource');
  }
}

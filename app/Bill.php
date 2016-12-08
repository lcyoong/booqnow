<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends TenantModel
{
  protected $primaryKey = 'bil_id';

  protected $fillable = ['bil_accounting', 'bil_customer', 'bil_booking', 'bil_description', 'bil_date', 'bil_due_date', 'bil_gross', 'bil_tax', 'bil_status', 'created_by'];

  public function getOutstandingAttribute($value)
  {
    return $this->bil_gross + $this->bil_tax - $this->bil_paid;
  }

  public function items()
  {
    return $this->hasMany(BillItem::class, 'bili_bill');
  }

  public function receipts()
  {
    return $this->hasMany(Receipt::class, 'rc_bill');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'bil_customer');
  }

  public function booking()
  {
    return $this->belongsTo(Booking::class, 'bil_booking');
  }

  public function refreshGrossTax()
  {
    $this->bil_gross = $this->items->sum('bili_gross');

    $this->bil_tax = $this->items->sum('bili_tax');

    $this->save();
  }

  public function refreshPaid()
  {
    $this->bil_paid = $this->receipts->sum('rc_amount');

    $this->save();
  }

  // public function scopeActive($query)
  // {
  //   return $query->where('bil_status', '=', 'active');
  // }
  public function getItems()
  {
    return $this->items()->join('resources', 'rs_id', 'bili_resource')->orderBy('rs_type')->get();
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends TenantModel
{
  protected $primaryKey = 'bil_id';

  protected $fillable = ['bil_customer', 'bil_booking', 'bil_description', 'bil_date', 'bil_due_date', 'bil_gross', 'bil_tax', 'bil_status', 'created_by'];

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

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends TenantModel
{
  protected $primaryKey = 'cus_id';

  protected $fillable = ['cus_first_name', 'cus_last_name', 'cus_email', 'cus_contact1', 'cus_contact2', 'cus_group', 'cus_address', 'cus_country', 'cus_status', 'created_by'];

  public function getFullNameAttribute($value)
  {
    return trim($this->cus_first_name . ' ' . $this->cus_last_name);
  }

  public function bills()
  {
    return $this->hasMany(Bill::class, 'bil_customer');
  }

  public function ltv()
  {
    return $this->bills->sum('bil_gross');
  }
}

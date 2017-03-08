<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends TenantModel
{
  protected $audit = false;

  protected $primaryKey = 'au_id';

  protected $fillable = ['au_model_type', 'au_mode', 'au_model_id', 'au_data', 'created_by'];

  public function com_model()
  {
    return $this->morphTo();
  }

  // public function bill()
  // {
  //   return $this->belongsTo(Bill::class, 'au_model_id')->where('au_model', '=', get_class(new Bill()));
  // }
  // 
  // public function customer()
  // {
  //   return $this->belongsTo(Customer::class, 'au_model_id')->where('au_model', '=', get_class(new Customer()));
  // }
  //
  // public function creator()
  // {
  //     return $this->belongsTo(User::class, 'created_by');
  // }
}

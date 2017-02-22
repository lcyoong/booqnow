<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends TenantModel
{
  protected $primaryKey = 'com_id';

  protected $fillable = ['com_model', 'com_model_id', 'com_content', 'created_by'];

  public function bill()
  {
    return $this->belongsTo(Bill::class, 'com_model_id')->where('com_model', '=', get_class(new Bill()));
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'com_model_id')->where('com_model', '=', get_class(new Customer()));
  }

  public function creator()
  {
      return $this->belongsTo(User::class, 'created_by');
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends TenantModel
{
  protected $primaryKey = 'rs_id';

  protected $fillable = ['rs_name', 'rs_description', 'rs_status', 'rs_price', 'rs_type', 'created_by'];

  public function getIdAttribute($value)
  {
    return $this->rs_id;
  }

  public function getTitleAttribute($value)
  {
    return $this->rs_name;
  }

  public function resourceType()
  {
    return $this->belongsTo(ResourceType::class, 'rs_type');
  }

}

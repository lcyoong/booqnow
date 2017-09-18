<?php

namespace App;

class ResourceSubType extends TenantModel
{
  protected $primaryKey = 'rsty_id';

  protected $fillable = ['rsty_type', 'rsty_code', 'rsty_name', 'rsty_status', 'created_by'];

  public function type()
  {
    return $this->belongsTo(ResourceType::class, 'rsty_type');
  }

  public function resources()
  {
    return $this->hasMany(Resource::class, 'rs_sub_type');
  }

  public static function getDropDown($type)
  {
    return ResourceSubType::where('rsty_type', '=', $type)->where('rsty_status', '=', 'active')->toDropDown('rsty_id', 'rsty_name');
  }

}

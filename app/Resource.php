<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;

class Resource extends TenantModel
{
  use AuditTrailRelationship;

  protected $audit = true;

  protected $primaryKey = 'rs_id';

  protected $fillable = ['rs_name', 'rs_description', 'rs_status', 'rs_price', 'rs_type', 'rs_label', 'rs_sub_type', 'created_by'];

  /**
   * Mutator to get the id of a resource
   * @return string
   */
  public function getIdAttribute($value)
  {
    return $this->rs_id;
  }

  /**
   * Mutator to get the title of the resource
   * @param  string $value
   * @return string
   */
  public function getTitleAttribute($value)
  {
    return $this->rs_name;
  }

  /**
   * Mutator to set the sub type field
   * @param string $value
   */
  public function setRsSubTypeAttribute($value)
  {
    $this->attributes['rs_sub_type'] = empty($value) ? null : $value;
  }

  /**
   * Get the resource type of the resource
   */
  public function resourceType()
  {
    return $this->belongsTo(ResourceType::class, 'rs_type');
  }

  /**
   * Get the resource sub type of the resource
   */
  public function subType()
  {
    return $this->belongsTo(ResourceSubType::class, 'rs_sub_type');
  }

  public function pricing()
  {
    return $this->hasMany(ResourcePricing::class, 'rpr_resource');
  }

}

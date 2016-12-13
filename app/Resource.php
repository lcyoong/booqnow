<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends TenantModel
{
  protected $primaryKey = 'rs_id';

  protected $fillable = ['rs_name', 'rs_description', 'rs_status', 'rs_price', 'rs_type', 'created_by'];

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
   * Get the resource type of the resource
   */
  public function resourceType()
  {
    return $this->belongsTo(ResourceType::class, 'rs_type');
  }

}

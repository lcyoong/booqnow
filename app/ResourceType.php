<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends TenantModel
{
  protected $primaryKey = 'rty_id';

  protected $fillable = ['rty_name', 'rty_price', 'created_by'];

  /**
   * Get the accounting of the resource type
   */
  public function accounting()
  {
    return $this->belongsTo(Accounting::class, 'rty_accounting');
  }
}

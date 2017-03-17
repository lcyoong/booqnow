<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends TenantModel
{
  protected $primaryKey = 'rep_id';

  protected $fillable = ['rep_function', 'rep_tries', 'rep_filter', 'rep_output_path', 'rep_status', 'created_by'];

  protected $appends = ['filter'];

  /**
   * Accessor to get the unserialized filter
   * @return numeric
   */
  public function getFilterAttribute()
  {
    return unserialize($this->rep_filter);
  }

}

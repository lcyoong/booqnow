<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Season extends TenantModel
{
  protected $primaryKey = 'sea_id';

  protected $appends = ['season_text'];

  /**
   * Mutator to get the text of the season with date range
   * @param  [type] $value [description]
   * @return string
   */
  public function getSeasonTextAttribute()
  {
    return trim($this->sea_name . ' - ' . Carbon::createFromFormat('Y-m-d', $this->sea_from)->format('d M') . ' to ' . Carbon::createFromFormat('Y-m-d', $this->sea_to)->format('d M'));
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends BaseModel
{
  protected $primaryKey = 'sub_id';
  protected $fillable = ['sub_merchant', 'sub_plan', 'sub_status', 'created_by'];

  /**
   * Get the merchant of the subscription
   */
  public function merchant()
  {
    return $this->belongsTo('App\Merchant', 'sub_merchant');
  }

  /**
   * Get the plan of the subscription
   */
  public function plan()
  {
    return $this->belongsTo('App\Plan', 'sub_plan');
  }

}

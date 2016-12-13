<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class MerchantUser extends BaseModel
{
  use EntrustUserTrait;

  protected $primaryKey = 'mus_id';

  protected $fillable = ['mus_user', 'mus_merchant', 'mus_status', 'created_by'];

  /**
   * Get the user of the merchant user
   */
  public function user()
  {
    return $this->belongsTo('App\User', 'mus_user');
  }

}

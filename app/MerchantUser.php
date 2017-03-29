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

  // public function role()
  // {
  //   return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
  // }

}

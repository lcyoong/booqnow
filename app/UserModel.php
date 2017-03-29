<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class UserModel extends User
{
  use EntrustUserTrait;
  use ModelTrait;

  protected $table = 'users';
  protected $primary_key = 'id';


  // public function role()
  // {
  //   // return $this->hasOne('App\Role', 'id', 'id');
  //   return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
  // }

  // public function merchantUser()
  // {
  //   $merchant = session('merchant');
  //
  //   return $this->hasOne('App\MerchantUser', 'mus_user')->where('mus_merchant', '=', $merchant->mer_id);
  // }

}

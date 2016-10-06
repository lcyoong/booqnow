<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MerchantUser extends BaseModel
{
  protected $primaryKey = 'mus_id';

  protected $fillable = ['mus_user', 'mus_merchant', 'mus_status', 'created_by'];

  public function user()
  {
    return $this->belongsTo('App\User', 'mus_user');
  }

}

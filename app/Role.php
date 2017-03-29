<?php

namespace App;

use Zizaco\Entrust\EntrustRole;
use App\Traits\ModelTrait;

class Role extends EntrustRole
{
  use ModelTrait;

  protected $fillable = ['name', 'display_name'];

  // public function permissions()
  // {
  //   return $this->belongsToMany('App\Permission', 'permission_role', 'role_id', 'permission_id');
  // }
}

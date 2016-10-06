<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends TenantModel
{
  protected $primaryKey = 'rty_id';

  protected $fillable = ['rty_name', 'rty_price', 'created_by'];

  // public static function create(array $attributes = [])
  // {
  //   dd($attributes);
  // }
}

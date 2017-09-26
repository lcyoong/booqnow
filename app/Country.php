<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends BaseModel
{
  protected $primaryKey = 'coun_code';

  public $incrementing = false;

  protected $fillable = ['coun_active'];

}

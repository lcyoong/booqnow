<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends TenantModel
{
  protected $primaryKey = 'com_id';

  protected $fillable = ['com_model_type', 'com_model_id', 'com_content', 'created_by'];

  public function com_model()
  {
    return $this->morphTo();
  }

}

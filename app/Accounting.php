<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounting extends TenantModel
{
  protected $table = 'accounting';

  protected $primaryKey = 'acc_id';
}

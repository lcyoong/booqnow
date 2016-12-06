<?php

namespace App;
use Config;
use DB;
use Booqnow\Tenant;

use Illuminate\Database\Eloquent\Model;

class TenantModel extends BaseModel
{
  public function __construct($attributes = array())
	{
    parent::__construct($attributes);

    if (config('myapp.multi_tenant')) {

      $merchant = session('merchant', null);

      $database = $merchant->mer_connection;

      Tenant::connect(['database' => $database]);

  		$this->connection = $database;
    }
	}

  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by');
  }
}

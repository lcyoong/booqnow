<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class SaasModel extends BaseModel
{
  public function __construct()
  {
    $this->connection = Config::get("database.default");
  }
}

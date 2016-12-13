<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class SaasModel extends BaseModel
{
  /**
   * Create a new model instance.
   */
  public function __construct()
  {
    $this->connection = Config::get("database.default");
  }
}

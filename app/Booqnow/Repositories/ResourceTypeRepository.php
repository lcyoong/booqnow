<?php

namespace Repositories;

use App\ResourceType;
use DB;

class ResourceTypeRepository extends BaseRepository{

  public function __construct()
  {
    parent::__construct('App\ResourceType');
  }

}

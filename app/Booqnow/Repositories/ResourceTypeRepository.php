<?php

namespace Repositories;

// use App\ResourceType;
use DB;
use Cache;

class ResourceTypeRepository extends BaseRepository{

  public function __construct()
  {
    parent::__construct('App\ResourceType');
  }

  // public function getDropDown()
  // {
  //   return Cache::remember('resource_type', 90, function()
  //   {
  //     return ResourceType::toDropDown('rty_id', 'rty_name');
  //   });
  //
  // }

}

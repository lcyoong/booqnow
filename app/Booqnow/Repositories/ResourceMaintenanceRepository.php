<?php

namespace Repositories;

use App\ResourceMaintenance;
use DB;
use Cache;

class ResourceMaintenanceRepository extends BaseRepository{

  public function __construct()
  {
    parent::__construct('App\ResourceMaintenance');

    $this->rules = [
      'rm_resource' => 'required|exists:resources,rs_id',
      'rm_from' => 'required|date',
      'rm_to' => 'required|date',
      'rm_description' => 'required|max:255',
    ];
  }

  // public function withResource()
  // {
  //   return $this->repo->join('resources', 'rs_id', '=', 'rm_resource');
  // }
}

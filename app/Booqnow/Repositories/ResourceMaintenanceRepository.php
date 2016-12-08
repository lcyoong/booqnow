<?php

namespace Repositories;

// use App\ResourceMaintenance;
use DB;
use Filters\ResourceMaintenanceFilter;
// use Cache;

class ResourceMaintenanceRepository extends BaseRepository{

  public function __construct()
  {
    parent::__construct('App\ResourceMaintenance');

    $this->filter = new ResourceMaintenanceFilter();

    $this->rules = [
      'rm_resource' => 'required|exists:resources,rs_id',
      'rm_from' => 'required|date',
      'rm_to' => 'required|date',
      'rm_description' => 'required|max:255',
    ];
  }

  public function start($date)
  {
    $this->filter->add(['start' => $date]);

    return $this;
  }

  public function end($date)
  {
    $this->filter->add(['end' => $date]);

    return $this;
  }

  // public function withResource()
  // {
  //   return $this->repo->join('resources', 'rs_id', '=', 'rm_resource');
  // }
}

<?php

namespace Repositories;

use DB;
use Filters\ResourceMaintenanceFilter;

class ResourceMaintenanceRepository extends BaseRepository{

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\ResourceMaintenance');

    $this->filter = new ResourceMaintenanceFilter();

    $this->rules = [
      'rm_resource' => 'required|exists:resources,rs_id|overlap_booking:rm_from,rm_to|overlap_maintenance:rm_from,rm_to',
      'rm_from' => 'required|date|before:rm_to',
      'rm_to' => 'required|date',
      'rm_description' => 'required|max:255',
    ];
  }

  /**
   * Add maintenance start date filter
   * @param  string $date - Date string
   * @return Repository
   */
  public function start($date)
  {
    $this->filter->add(['start' => $date]);

    return $this;
  }

  /**
   * Add maintenance end date filter
   * @param  string $date - Date string
   * @return Repository
   */
  public function end($date)
  {
    $this->filter->add(['end' => $date]);

    return $this;
  }

  public function getInYear($year) 
  {
      return $this->repo
                ->whereYear('rm_from', '>=', $year)
                ->whereYear('rm_to', '<=', $year)->get();
  }
}

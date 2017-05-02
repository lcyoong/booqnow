<?php

namespace Repositories;

use Filters\ResourceFilter;
use DB;

class ResourceRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Resource');

    $this->filter = new ResourceFilter();

    $this->rules = [
      'rs_type' => 'required|exists:resource_types,rty_id',
      'rs_name' => 'required|max:255',
      'rs_price' => 'required|numeric',
    ];

    $this->alt_rules[0] = [
      'rs_type' => '',
    ];

  }

  /**
   * Add resource status filter to query
   * @param  string $value
   * @return Repository
   */
  public function ofStatus($value)
  {
    $this->filter->add(['status' => $value]);

    return $this;
  }

  /**
   * Add resource type filter to query
   * @param  string $value
   * @return Repository
   */
  public function ofType($value)
  {
    $this->filter->add(['type' => $value]);

    return $this;
  }

  public function occupancyByRoom($year)
  {
    return $this->repo->select(DB::raw("rs_name, month(ro_date) as mth, count(*) as counter"))
                ->leftJoin('room_occupancies', 'ro_room', '=', 'rs_id')
                ->join('resource_types', 'rty_id', '=', 'rs_type')
                ->where('rty_id', '=', 1)
                ->groupBy(DB::raw("rs_name, month(ro_date)"))->get();
  }

  public function countByType($value = [])
  {
    return $this->repo->whereIn('rs_type', $value)->where('rs_status', '=', 'active')->count();
  }

}

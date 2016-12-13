<?php

namespace Filters;

class ResourceMaintenanceFilter extends QueryFilter
{
  /**
   * Resource maintenance status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_status", '=', "active");
    }
  }

  /**
   * Resource filter
   * @param  string $value
   * @return Builder
   */
  public function resource($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_resource", '=', $value);
    }
  }

  /**
   * Resource type filter
   * @param  string $value
   * @return Builder
   */
  public function type($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinResources';

      return $this->builder->where("rs_type", 'like', "%$value%");
    }
  }

  /**
   * Maintenance end date filter
   * @param  string $value
   * @return Builder
   */
  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_to", '>', $value);
    }
  }

  /**
   * Maintenance start date filter
   * @param  string $value
   * @return Builder
   */
  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_from", '<', $value);
    }
  }

  /**
   * Join resources to query
   * @return Builder
   */
  public function joinResources()
  {
    $this->builder->join('resources', 'rs_id', 'rm_resource');
  }

}

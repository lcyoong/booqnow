<?php

namespace Filters;

class AddonFilter extends QueryFilter
{
  /**
   * Resource type filter
   * @param  string $value
   * @return Builder
   */
  public function resourceType($value)
  {
    if (!empty($value)) {

      $this->joins[] = 'joinResources';

      return $this->builder->where("rs_type", '=', $value);
    }
  }

  /**
   * Date filter
   * @param  string $value
   * @return Builder
   */
  public function onDate($value)
  {
    if (!empty($value)) {

      return $this->builder->where("add_date", '=', $value);
    }
  }

  /**
   * Trancking no filter
   * @param  string $value
   * @return Builder
   */
  public function tracking($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("add_tracking", '=', $value);
    }
  }

  /**
   * Reference no filter
   * @param  string $value
   * @return Builder
   */
  public function reference($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("add_reference", '=', $value);
    }
  }

  /**
   * Join resources to query
   * @return Builder
   */
  public function joinResources()
  {
    $this->builder->join('resources', 'rs_id', 'add_resource');
  }

}

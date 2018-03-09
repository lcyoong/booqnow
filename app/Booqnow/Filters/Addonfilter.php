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

  public function masterType($value = 0)
  {
    $this->joins[] = 'joinResources';
    $this->joins[] = 'joinResourceTypes';

    return $this->builder->where("rty_master", '=', $value);
  }

  /**
   * Date filter
   * @param  string $value
   * @return Builder
   */
  public function onDate($value)
  {
    if (!empty($value)) {

      return $this->builder->where("add_date", 'like', "%$value%");
    }
  }

  /**
   * Date filter
   * @param  string $value
   * @return Builder
   */
  public function fromDate($value)
  {
    if (!empty($value)) {

      return $this->builder->where("add_date", '>=', date('YmdHis', strtotime($value)));
    }
  }

  /**
   * Date filter
   * @param  string $value
   * @return Builder
   */
  public function toDate($value)
  {
    if (!empty($value)) {

      return $this->builder->where("add_date", '<=', date('YmdHis', strtotime($value)));
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
    $this->builder->join('resources', 'rs_id', '=', 'add_resource');
  }

  public function joinResourceTypes()
  {
    $this->builder->join('resource_types', 'rty_id', '=', 'rs_type');
  }

  public function ofYear($value)
  {
    if (!empty($value)) {
      return $this->builder->whereYear('add_date', $value);
    }
  }

  public function notInStatus($value = [])
  {
    if (!empty($value)) {

      return $this->builder->whereNotIn('add_status', $value);

    }
  }

}

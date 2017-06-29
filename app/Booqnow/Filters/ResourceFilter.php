<?php

namespace Filters;

class ResourceFilter extends QueryFilter
{
  /**
   * Resource name filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_name", 'like', "%$value%");
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

      return $this->builder->where("rs_type", '=', $value);
    }
  }

  /**
   * Resource type filter
   * @param  string $value
   * @return Builder
   */
  public function master($value = false)
  {
    $this->joins[] = 'joinResourceTypes';

    return $this->builder->where("rty_master", '=', $value);
  }

  /**
   * Resource label filter
   * @param  string $value
   * @return Builder
   */
  public function label($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_label", '=', $value);
    }
  }

  /**
   * Resource status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_status", '=', "active");
    }
  }

  public function joinResourceTypes()
  {
    $this->builder->join('resource_types', 'rty_id', '=', 'rs_type');
  }

}

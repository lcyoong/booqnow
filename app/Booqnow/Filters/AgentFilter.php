<?php

namespace Filters;

class AgentFilter extends QueryFilter
{
  /**
   * Description filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("ag_name", 'like', "%$value%");
    }
  }

  /**
   * Status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("ag_status", '=', $value);
    }
  }

  /**
   * Type filter
   * @param  string $value
   * @return Builder
   */
  public function type($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("ag_type", '=', $value);
    }
  }

}

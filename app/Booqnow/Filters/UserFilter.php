<?php

namespace Filters;

class UserFilter extends QueryFilter
{
  /**
   * Name filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('name', 'like', "%$value%");

    }
  }

  /**
   * Email filter
   * @param  string $value
   * @return Builder
   */
  public function email($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('email', 'like', "%$value%");

    }
  }

  /**
   * Status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_status", '=', $value);
    }
  }

}

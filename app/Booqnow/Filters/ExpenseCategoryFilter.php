<?php

namespace Filters;

class ExpenseCategoryFilter extends QueryFilter
{
  /**
   * Resource name filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("exc_name", 'like', "%$value%");
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

      return $this->builder->where("exc_status", '=', $value);
    }
  }

}

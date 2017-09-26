<?php

namespace Filters;

class CountryFilter extends QueryFilter
{
  /**
   * Description filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("coun_name", 'like', "%$value%");
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

      return $this->builder->where("coun_active", '=', $value);
    }
  }

}

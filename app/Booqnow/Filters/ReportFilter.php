<?php

namespace Filters;

class ReportFilter extends QueryFilter
{
  /**
   * Report type filter
   * @param  string $value
   * @return Builder
   */
  public function type($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('rep_function', '=', $value);

    }
  }
}

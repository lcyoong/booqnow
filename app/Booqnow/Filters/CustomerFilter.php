<?php

namespace Filters;

class CustomerFilter extends QueryFilter
{
  /**
   * Customer name filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->whereRaw("concat(cus_first_name, ' ', cus_last_name) like '%$value%'");
    }
  }

  /**
   * Customer country filter
   * @param  string $value
   * @return Builder
   */
  public function country($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cus_country', '=', $value);
    }
  }

  /**
   * Customer contact no filter
   * @param  string $value
   * @return Builder
   */
  public function contact1($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cus_contact1', 'like', "%$value%");
    }
  }

  /**
   * Customer email filter
   * @param  string $value
   * @return Builder
   */
  public function email($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cus_email', 'like', "%$value%");
    }
  }

  /**
   * Customer status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("cus_status", '=', "active");
    }
  }

}

<?php

namespace Filters;

class ExpenseFilter extends QueryFilter
{
  /**
   * Description filter
   * @param  string $value
   * @return Builder
   */
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("exp_description", 'like', "%$value%");
    }
  }

  /**
   * Date filter
   * @param  string $value
   * @return Builder
   */
  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("exp_date", '>=', date('Y-m-d', strtotime($value)));
    }
  }

  /**
   * Date filter
   * @param  string $value
   * @return Builder
   */
  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("exp_date", '<=', date('Y-m-d', strtotime($value)));
    }
  }

  /**
   * Category filter
   * @param  string $value
   * @return Builder
   */
  public function category($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("exp_category", '=', $value);
    }
  }

  /**
   * Account filter
   * @param  string $value
   * @return Builder
   */
  public function account($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("exp_account", '=', $value);
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

      return $this->builder->where("exp_status", '=', $value);
    }
  }

  /**
   * Payable filter
   * @param  string $value
   * @return Builder
   */
  public function payable($value = '')
  {
    if (!empty($value)) {
      return $this->builder->where("exp_payable", 'like', "%$value%");
    }
  }

  /**
   * Method filter
   * @param  string $value
   * @return Builder
   */
  public function method($value = '')
  {
    if (!empty($value)) {
      return $this->builder->where("exp_method", '=', $value);
    }
  }  
}

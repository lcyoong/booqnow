<?php

namespace Filters;

class ReceiptFilter extends QueryFilter
{
  /**
   * Customer name filter
   * @param  string $value
   * @return Builder
   */
  public function customer_name($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinCustomers';

      return $this->builder->whereRaw("concat(cus_first_name, ' ', cus_last_name) like '%$value%'");
    }
  }

  /**
   * Bill no filter
   * @param  string $value
   * @return Builder
   */
  public function bill($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rc_bill", '=', $value);
    }
  }

  /**
   * Receipt status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("rc_status", '=', $value);
    }
  }

  /**
   * Join customers to query
   * @return Builder
   */
  public function joinCustomers()
  {
    $this->builder->join('customers', 'cus_id', 'rc_customer');
  }

}

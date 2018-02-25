<?php

namespace Filters;

class BillFilter extends QueryFilter
{
  /**
   * Customer name filter
   * @param  string $value
   * @return Builder
   */
  public function customer_name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->whereRaw("trim(concat(trim(cus_first_name), ' ', trim(cus_last_name))) like '%$value%'");
      
    }
  }

  /**
   * Customer email filter
   * @param  string $value
   * @return Builder
   */
  public function customer_email($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinCustomers';

      return $this->builder->where('cus_email', 'like', "%$value%");
    }
  }

  /**
   * Booking filter
   * @param  string $value
   * @return Builder
   */
  public function booking($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_booking", '=', $value);
    }
  }

  /**
   * Bill id filter
   * @param  string $value
   * @return Builder
   */
  public function id($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_id", '=', $value);
    }
  }

  /**
   * Bill status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_status", '=', $value);
    }
  }

  /**
   * Bill date start filter
   * @param  string $value
   * @return Builder
   */
  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_date", '>=', date('Y-m-d', strtotime($value)));
    }
  }

  /**
   * Bill date end filter
   * @param  string $value
   * @return Builder
   */
  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_date", '<=', date('Y-m-d', strtotime($value)));
    }
  }

  public function ofBookStatus($value)
  {
    if (!empty($value)) {

      $this->joins[] = 'joinBookings';

      return $this->builder->whereIn('book_status', $value);
    }
  }

  public function ofYear($value)
  {
    if (!empty($value)) {

      return $this->builder->whereYear('bil_date', $value);
    }
  }

  /**
   * Join customers to query
   * @return Builder
   */
  public function joinCustomers()
  {
    $this->builder->join('customers', 'cus_id', 'bil_customer');
  }

  /**
   * Join resources to query
   * @return Builder
   */
  public function joinBookings()
  {
    $this->builder->join('bookings', 'book_id', '=', 'bil_booking');
  }

}

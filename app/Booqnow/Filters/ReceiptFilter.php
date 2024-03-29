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

      $this->joins[] = 'joinBills';

      return $this->builder->where("bil_customer_name", "like", "%$value%");
    }
  }

  /**
   * Booking status filter
   * @param  string $value
   * @return Builder
   */
  public function book_status($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinBills';
      $this->joins[] = 'joinBookings';

      return $this->builder->where("book_status", "=", $value);
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
   * Receipt date start filter
   * @param  string $value
   * @return Builder
   */
  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rc_date", '>=', date('Y-m-d', strtotime($value)));
    }
  }

  /**
   * Receipt date end filter
   * @param  string $value
   * @return Builder
   */
  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rc_date", '<=', date('Y-m-d', strtotime($value)));
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

      return $this->builder->where('rc_method', '=', $value);
    }
  }

  public function ofYear($value)
  {
    if (!empty($value)) {

      return $this->builder->whereYear('rc_date', $value);
    }
  }

  public function ofType($value)
  {
    if (!empty($value)) {
      return $this->builder->where('rc_type', '=', $value);
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

  /**
   * Join customers to query
   * @return Builder
   */
  public function joinBills()
  {
    $this->builder->join('bills', 'bil_id', 'rc_bill');
  }

  /**
   * Join bookings to query
   * @return Builder
   */
  public function joinBookings()
  {
    $this->builder->join('bookings', 'book_id', 'bil_booking');
  }  
}

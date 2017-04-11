<?php

namespace Filters;

class BookingFilter extends QueryFilter
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
   * Agent name filter
   * @param  string $value
   * @return Builder
   */
  public function agent_name($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinAgents';

      return $this->builder->whereRaw("ag_name like '%$value%'");
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
   * Booking status filter
   * @param  string $value
   * @return Builder
   */
  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("book_status", '=', $value);
    }
  }

  /**
   * Booking check out date filter
   * @param  string $value
   * @return Builder
   */
  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_to", '>', $value);
    }
  }

  /**
   * Booking check in date filter
   * @param  string $value
   * @return Builder
   */
  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_from", '<', $value);
    }
  }

  /**
   * Booking tracking no filter
   * @param  string $value
   * @return Builder
   */
  public function tracking($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_tracking", '=', $value);
    }
  }

  /**
   * Booking reference filter
   * @param  string $value
   * @return Builder
   */
  public function reference($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_reference", '=', $value);
    }
  }

  /**
   * Booking check in date filter
   * @param  string $value
   * @return Builder
   */
  public function onStart($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_from", '=', $value);
    }
  }

  /**
   * Booking check out date filter
   * @param  string $value
   * @return Builder
   */
  public function onEnd($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_to", '=', $value);
    }
  }

  public function notStatus($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_status", '!=', $value);
    }
  }

  /**
   * Join customers to query
   * @return Builder
   */
  public function joinCustomers()
  {
    $this->builder->join('customers', 'cus_id', 'book_customer');
  }

  /**
   * Join angents to query
   * @return Builder
   */
  public function joinAgents()
  {
    $this->builder->join('agents', 'ag_id', 'book_agent');
  }

}

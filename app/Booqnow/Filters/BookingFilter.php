<?php

namespace Filters;

class BookingFilter extends QueryFilter
{
  public function customer_name($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinCustomers';

      return $this->builder->whereRaw("concat(cus_first_name, ' ', cus_last_name) like '%$value%'");
    }
  }

  public function customer_email($value = '')
  {
    if (!empty($value)) {

      $this->joins[] = 'joinCustomers';

      return $this->builder->where('cus_email', 'like', "%$value%");
    }
  }

  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("book_status", '=', $value);
    }
  }

  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_to", '>', $value);
    }
  }

  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_from", '<', $value);
    }
  }

  public function tracking($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_tracking", '=', $value);
    }
  }

  public function reference($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_reference", '=', $value);
    }
  }

  public function onStart($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_from", '=', $value);
    }
  }

  public function onEnd($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("book_to", '=', $value);
    }
  }

  public function joinCustomers()
  {
    $this->builder->join('customers', 'cus_id', 'book_customer');
  }

}

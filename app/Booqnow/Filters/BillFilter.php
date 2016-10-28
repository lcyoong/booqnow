<?php

namespace App;

class BillFilter extends QueryFilter
{
  public function customer_name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->whereRaw("concat(cus_first_name, ' ', cus_last_name) like '%$value%'");
    }
  }

  public function customer_email($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cust_email', '=', $value);
    }
  }

  public function booking($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_booking", '=', $value);
    }
  }

  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_status", '=', $value);
    }
  }

  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_date", '>=', $value);
    }
  }

  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("bil_date", '<=', $value);
    }
  }
}

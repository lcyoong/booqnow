<?php

namespace App;

class ReceiptFilter extends QueryFilter
{
  public function customer_name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->whereRaw("concat(cus_first_name, ' ', cus_last_name) like '%$value%'");
    }
  }

  public function bill($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rc_bill", '=', $value);
    }
  }

  public function status($value = 'active')
  {
    if (!empty($value)) {

      return $this->builder->where("rc_status", '=', $value);
    }
  }
}

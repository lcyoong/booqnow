<?php

namespace Filters;

class CustomerFilter extends QueryFilter
{
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->whereRaw("concat(cus_first_name, ' ', cus_last_name) like '%$value%'");
    }
  }

  public function country($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cus_country', '=', $value);
    }
  }

  public function contact1($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cus_contact1', 'like', "%$value%");
    }
  }

  public function email($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where('cus_email', 'like', "%$value%");
    }
  }

  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("cus_status", '=', "active");
    }
  }

}

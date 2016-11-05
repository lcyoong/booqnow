<?php

namespace App;

class ResourceFilter extends QueryFilter
{
  public function name($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_name", 'like', "%$value%");
    }
  }

  public function type($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_type", 'like', "%$value%");
    }
  }

  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_status", '=', "active");
    }
  }

}

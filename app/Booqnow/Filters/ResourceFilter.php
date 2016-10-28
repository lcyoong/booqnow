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

  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_status", '=', "active");
    }
  }

}

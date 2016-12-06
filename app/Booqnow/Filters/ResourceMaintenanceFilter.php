<?php

namespace App;

class ResourceMaintenanceFilter extends QueryFilter
{
  public function status($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_status", '=', "active");
    }
  }

  public function resource($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_resource", '=', $value);
    }
  }

  public function type($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rs_type", 'like', "%$value%");
    }
  }

  public function start($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_to", '>', $value);
    }
  }

  public function end($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("rm_from", '<', $value);
    }
  }

}

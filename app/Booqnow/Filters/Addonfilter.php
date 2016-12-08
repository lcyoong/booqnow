<?php

namespace Filters;

class AddonFilter extends QueryFilter
{
  public function resourceType($value)
  {
    if (!empty($value)) {

      $this->joins[] = 'joinResources';

      return $this->builder->where("rs_type", '=', $value);
    }
  }

  public function onDate($value)
  {
    if (!empty($value)) {

      return $this->builder->where("add_date", '=', $value);
    }
  }

  public function tracking($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("add_tracking", '=', $value);
    }
  }

  public function reference($value = '')
  {
    if (!empty($value)) {

      return $this->builder->where("add_reference", '=', $value);
    }
  }

  public function joinResources()
  {
    $this->builder->join('resources', 'rs_id', 'add_resource');
  }

}

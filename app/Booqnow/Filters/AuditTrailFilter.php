<?php

namespace Filters;

class AuditTrailFilter extends QueryFilter
{
  public function model($value)
  {
    if (!empty($value)) {

      return $this->builder->where("au_model", '=', $value);
    }
  }

  public function modelId($value)
  {
    if (!empty($value)) {

      return $this->builder->where("au_model_id", '=', $value);
    }
  }

}

<?php

namespace Filters;

class AuditTrailFilter extends QueryFilter
{
  public function modelType($value)
  {
    if (!empty($value)) {

      return $this->builder->where("au_model_type", '=', $value);
    }
  }

  public function modelId($value)
  {
    if (!empty($value)) {

      return $this->builder->where("au_model_id", '=', $value);
    }
  }

}

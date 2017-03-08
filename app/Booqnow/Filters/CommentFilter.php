<?php

namespace Filters;

class CommentFilter extends QueryFilter
{
  public function modelType($value)
  {
    if (!empty($value)) {

      return $this->builder->where("com_model_type", '=', $value);
    }
  }

  public function modelId($value)
  {
    if (!empty($value)) {

      return $this->builder->where("com_model_id", '=', $value);
    }
  }

}

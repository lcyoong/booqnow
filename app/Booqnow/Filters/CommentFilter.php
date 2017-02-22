<?php

namespace Filters;

class CommentFilter extends QueryFilter
{
  public function model($value)
  {
    if (!empty($value)) {

      return $this->builder->where("com_model", '=', $value);
    }
  }

  public function modelId($value)
  {
    if (!empty($value)) {

      return $this->builder->where("com_model_id", '=', $value);
    }
  }

}

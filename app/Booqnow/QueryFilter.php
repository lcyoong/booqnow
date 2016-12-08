<?php

namespace Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter {

  protected $request;

  protected $builder;

  protected $joins;

  public function __construct($request = [])
  {
    $this->request = $request;

    $this->joins = [];
  }

  public function add($add)
  {
    $this->request += $add;
  }

  public function filters()
  {
    return $this->request;
  }

  public function joins()
  {
    return $this->joins;
  }

  public function apply(Builder $builder)
  {
    $this->builder = $builder;

    foreach ($this->filters() as $name => $value) {
      if (method_exists($this, $name)) {
        call_user_func_array([$this, $name], array_filter([$value]));
      }
    }

    foreach (array_unique($this->joins()) as $join) {
      if (method_exists($this, $join)) {
        call_user_func_array([$this, $join], []);
      }
    }
    return $this->builder;
  }
}

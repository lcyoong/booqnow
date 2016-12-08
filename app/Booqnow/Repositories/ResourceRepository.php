<?php

namespace Repositories;

// use App\Resource;
use Filters\ResourceFilter;
use DB;

class ResourceRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Resource');

    $this->filter = new ResourceFilter();

    $this->rules = [
      'rs_type' => 'required|exists:resource_types,rty_id',
      'rs_name' => 'required|max:255',
      'rs_price' => 'required|numeric',
    ];

    $this->alt_rules[0] = [
      'rs_type' => '',
    ];

  }

  public function ofStatus($value)
  {
    $this->filter->add(['status' => $value]);

    return $this;
  }

  public function ofType($value)
  {
    $this->filter->add(['type' => $value]);

    return $this;
  }

  // public function getDropDown()
  // {
  //   return $this->repo->toDropDown('rs_id', 'rs_name');
  //
  // }

}

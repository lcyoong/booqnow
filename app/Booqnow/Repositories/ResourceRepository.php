<?php

namespace Repositories;

use App\Resource;
use DB;

class ResourceRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Resource');

    $this->rules = [
      'rs_type' => 'required|exists:resource_types,rty_id',
      'rs_name' => 'required|max:255',
      'rs_price' => 'required|numeric',
    ];

    $this->alt_rules[0] = [
      'rs_type' => '',
    ];

  }

  public function getDropDown($filters)
  {
    return Resource::filter($filters)->toDropDown('rs_id', 'rs_name');

  }

}

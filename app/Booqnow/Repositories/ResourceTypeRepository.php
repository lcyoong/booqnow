<?php

namespace Repositories;

// use App\ResourceType;
use DB;
use Cache;

class ResourceTypeRepository extends BaseRepository{

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\ResourceType');

    $this->rules = [
      'rty_name' => 'required|max:255',
      'rty_price' => 'required|numeric',
    ];

  }
}

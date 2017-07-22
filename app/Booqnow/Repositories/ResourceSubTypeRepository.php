<?php

namespace Repositories;

// use App\ResourceType;
use DB;
use Cache;

class ResourceSubTypeRepository extends BaseRepository{

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\ResourceSubType');

    $this->rules = [
      'rsty_type' => 'required|exists:resource_types,rty_id',
      'rsty_code' => 'required|max:255',
      'rsty_name' => 'required|max:255',
    ];

  }
}

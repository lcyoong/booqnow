<?php

namespace Repositories;

use Illuminate\Http\Request;
use DB;
// use Filters\UserFilter;

class PermissionRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Permission');

    // $this->filter = new UserFilter();

    $this->rules = [
      'name' => 'required',
      'display_name' => 'required',
    ];
  }
}

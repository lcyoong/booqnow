<?php

namespace Repositories;

use Illuminate\Http\Request;
use DB;

class AgentRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Agent');

    $this->rules = [
      'ag_name' => 'required',
    ];
  }
}

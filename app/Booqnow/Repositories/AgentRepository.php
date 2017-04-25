<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\AgentFilter;
use DB;

class AgentRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    $this->filter = new AgentFilter();

    parent::__construct('App\Agent');

    $this->rules = [
      'ag_name' => 'required',
      'ag_type' => 'required',
    ];
  }


  /**
   * Add filter - type
   * @param  string $value
   * @return Repository
   */
  public function ofType($value)
  {
    $this->filter->add(['type' => $value]);

    return $this;
  }

}

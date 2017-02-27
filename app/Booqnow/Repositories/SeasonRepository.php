<?php

namespace Repositories;

use Illuminate\Http\Request;
// use Filters\BillFilter;
use DB;

class SeasonRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Season');

    // $this->filter = new BillFilter();
  }
}

<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\AuditTrailFilter;
use DB;

class AuditTrailRepository extends BaseRepository {

  /**
   * Create a new repository instance.
   */
  public function __construct()
  {
    $this->filter = new AuditTrailFilter();

    parent::__construct('App\AuditTrail');

    $this->rules = [];
  }
}

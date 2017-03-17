<?php

namespace Repositories;

use Filters\ReportFilter;
use DB;

class ReportRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Report');
  }

  public function ofType($value)
  {
    $this->filter = new ReportFilter();

    $this->filter->add(['type' => $value]);

    return $this;
  }
}

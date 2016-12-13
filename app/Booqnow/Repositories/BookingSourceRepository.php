<?php

namespace Repositories;

// use App\BookingSource;
use DB;
use Cache;

class BookingSourceRepository extends BaseRepository{

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\BookingSource');
  }
}

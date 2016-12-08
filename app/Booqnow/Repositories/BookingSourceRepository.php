<?php

namespace Repositories;

// use App\BookingSource;
use DB;
use Cache;

class BookingSourceRepository extends BaseRepository{

  public function __construct()
  {
    parent::__construct('App\BookingSource');
  }

  // public function getDropDown()
  // {
  //   return Cache::remember('booking_source', 90, function()
  //   {
  //     return BookingSource::toDropDown('bs_id', 'bs_description');
  //   });
  //
  // }

}

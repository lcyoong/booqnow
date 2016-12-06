<?php

namespace Repositories;

use App\Country;

use Cache;

class CountryRepository {

  public function getDropDown()
  {
    return Cache::remember('countries', 90, function()
    {
      return Country::orderBy('coun_name', 'asc')->toDropDown('coun_code', 'coun_name');
    });

  }
}

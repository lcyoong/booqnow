<?php

namespace Repositories;

use App\Country;

use Cache;

class CountryRepository {

  /**
   * Get the key-value array of the query
   * @return array
   */
  public function getDropDown()
  {
    return Cache::remember('countries', 90, function()
    {
      return Country::orderBy('coun_name', 'asc')->toDropDown('coun_code', 'coun_name');
    });

  }
}

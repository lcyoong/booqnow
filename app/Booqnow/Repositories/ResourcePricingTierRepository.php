<?php

namespace Repositories;

use Illuminate\Http\Request;
// use Filters\BillFilter;
use DB;

class ResourcePricingTierRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\ResourcePricingtier');


    $this->rules = [
      'rpt_from' => 'required|numeric',
      'rpt_to' => 'required|numeric',
      'rpt_price' => 'required|numeric|min:0.01'
    ];
  }
}

<?php

namespace Repositories;

use Illuminate\Http\Request;
// use Filters\BillFilter;
use DB;

class ResourcePricingRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\ResourcePricing');


    $this->rules = [
      'rpr_resource' => 'required|exists:resources,rs_id',
      // 'rpr_season' => [
      //   'required',
      //   'exists:seasons,sea_id',
      //   Rule::unique('resource_pricing')->where(function ($query) {
      //     $query->where()
      //   })
      // ],
      'rpr_season' => 'required|exists:seasons,sea_id|composite_unique:resource_pricings,rpr_season,rpr_resource',
      'rpr_price' => 'required|numeric|min:0.01'
    ];
    // $this->filter = new BillFilter();
  }
}

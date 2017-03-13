<?php

namespace Repositories;

use Illuminate\Http\Request;

use DB;

class BillItemRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\BillItem');

    $this->rules = [
      'bili_bill' => 'required|exists:bills,bil_id',
      'bili_resource' => 'sometimes|exists:resources,rs_id',
      'bili_unit' => 'required|numeric|min:1',
      'bili_unit_price' => 'numeric|min:0.01',      
      // 'bili_gross' => 'sometimes|numeric|min:0',
      // 'bili_tax' => 'sometimes|numeric|min:0',
    ];
  }
}

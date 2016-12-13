<?php

namespace Repositories;

use DB;

class MerchantRepository extends BaseRepository{

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Merchant');

    $this->filter = new CustomerFilter();

    $this->rules = [
      'mer_name' => 'required|max:255',
      'mer_country' => 'required',
    ];
  }
}

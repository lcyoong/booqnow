<?php

namespace Repositories;

use App\Resource;
use DB;

class ReceiptRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Receipt');

    $this->rules = [
      // 'rc_customer' => 'required|exits:customers,cus_id',
      'rc_bill' => 'required|exists:bills,bil_id',
      'rc_date' => 'required|date',
      'rc_amount' => 'required|numeric|min:0',
      'rc_method' => 'required',
    ];
  }
}

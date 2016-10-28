<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\CustomerRepository;
use App\CustomerFilter;

class CustomerApiController extends ApiController
{
  public function active(Request $request)
  {
    $input = $request->input();

    $rs = new CustomerRepository;

    $filters = new CustomerFilter(['status' => 'active', 'name' => array_get($input, 'q')]);

    $list = $rs->get($filters, 5);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = ['id' => $item->cus_id, 'title' => $item->full_name, 'extra' => $item->cus_email];
    }

    return $return;

  }
}

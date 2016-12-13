<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\CustomerRepository;
use Filters\CustomerFilter;

class CustomerApiController extends ApiController
{
  /**
   * Get active customers given the parameters
   * @param  Request $request
   * @return array
   */
  public function active(Request $request)
  {
    $input = $request->input();

    $filters = new CustomerFilter(['status' => 'active', 'name' => array_get($input, 'q')]);

    $list = (new CustomerRepository)->get($filters, 5);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = ['id' => $item->cus_id, 'title' => $item->full_name, 'extra' => $item->cus_email];
    }

    return $return;

  }
}

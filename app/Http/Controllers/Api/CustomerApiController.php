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

    $list = (new CustomerRepository)->get($filters);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = ['id' => $item->cus_id, 'title' => $item->full_name, 'extra' => $item->cus_email];
    }

    return $return;

  }

  public function show ($id)
  {
    return (new CustomerRepository)->findById($id);
  }

  public function comments($id)
  {
    $customer = $this->show($id);

    return $customer->comments()->with('creator')->get();
  }
}

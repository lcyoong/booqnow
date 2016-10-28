<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\ResourceRepository;
use App\ResourceFilter;

class ResourceApiController extends ApiController
{
  public function active()
  {
    $rs = new ResourceRepository;

    $filters = new ResourceFilter(['status' => 'active']);

    $list = $rs->get($filters);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = ['id' => $item->rs_id, 'title' => $item->rs_name];
    }

    return $return;

  }
}

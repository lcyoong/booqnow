<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\ResourceRepository;
use Repositories\ResourceTypeRepository;
use Repositories\ResourceMaintenanceRepository;
// use App\ResourceType;
use Filters\ResourceFilter;
use Filters\ResourceMaintenanceFilter;

class ResourceApiController extends ApiController
{
  public function active($rty_id)
  {
    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    // $rs = new ResourceRepository;

    // $filters = new ResourceFilter(['status' => 'active', 'type' => $resource_type->rty_id]);

    $list = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->get();

    $return = [];

    foreach ($list as $item)
    {
      $return[] = ['id' => $item->rs_id, 'title' => $item->rs_name, 'price' => showMoney($item->rs_price, true)];
    }

    return $return;

  }

  public function maintenance(Request $request)
  {
    // $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $input = $request->input();

    // $rs = new ResourceMaintenanceRepository;

    // $filters = new ResourceMaintenanceFilter(['start' => array($input, 'start'), 'end' => array($input, 'end')]);

    $list = (new ResourceMaintenanceRepository)->start(array($input, 'start'))->end(array($input, 'end'))->get();

    $return = [];

    foreach ($list as $item)
    {
      $return[] = [
        'type' => 'maintenance',
        'id' => $item->rm_id,
        'title' => $item->rm_description,
        'start' => $item->rm_from,
        'end' => $item->rm_to,
        'resourceId' => $item->rm_resource,
        'status' => $item->rm_status,
        'backgroundColor' => '#999999',
        'borderColor' => 'transparent',
      ];
    }

    // dd($list);

    return $return;

  }

}

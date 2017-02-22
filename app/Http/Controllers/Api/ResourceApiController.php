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
  /**
   * Get the active resources given the parameters
   * @param  int $rty_id - Resource type id
   * @return array
   */
  public function active($rty_id, $mode = '')
  {
    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $list = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->get();

    $return = [];

    if ($mode == 'select') {
      foreach ($list as $item)
      {
        $return[] = ['id' => $item->rs_id, 'text' => $item->rs_name, 'price' => $item->rs_price];
      }
    } else {
      foreach ($list as $item)
      {
        $return[] = ['id' => $item->rs_id, 'title' => $item->rs_name, 'price' => showMoney($item->rs_price, true)];
      }
    }

    return $return;
  }

  /**
   * Get the list of resource maintenance given the parameters
   * @param  Request $request
   * @return array
   */
  public function maintenance(Request $request)
  {
    $input = $request->input();

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
        'backgroundColor' => '#FF0000',
        'borderColor' => 'transparent',
      ];
    }

    return $return;
  }

}

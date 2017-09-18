<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\ResourceRepository;
use Repositories\ResourceTypeRepository;
use Repositories\ResourcePricingRepository;
use Repositories\ResourceMaintenanceRepository;
// use App\ResourceType;
use Filters\ResourceFilter;
use Filters\ResourceMaintenanceFilter;
use Carbon\Carbon;
use App\ResourceSubType;

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
        $return[] = ['id' => $item->rs_id, 'text' => $item->rs_name, 'price' => (int) $item->rs_price];
      }
    } else {
      foreach ($list as $item)
      {
        $return[] = ['id' => $item->rs_id, 'title' => $item->rs_name, 'price' => showMoney($item->rs_price)];
      }
    }

    return $return;
  }

  /**
   * Get the active resources given the parameters
   * @param  int $rty_id - Resource type id
   * @return array
   */
  public function activeGrouped($rty_id)
  {
    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $list = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->orderBy('rs_sub_type', 'asc')->get();

    $return = [];

    foreach ($list as $item)
    {
      $return[!is_null($item->rs_sub_type) ? $item->rs_sub_type : 0][] = ['id' => $item->rs_id, 'text' => $item->rs_name, 'price' => (int) $item->rs_price];
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

  public function pricing($resource, Request $request)
  {
    $rs = new ResourceRepository;

    return $rs->findById($resource)->pricing()->with(['season', 'tiers'])->get();
  }

  public function ofLabel($label, Request $request)
  {
    $rs = new ResourceRepository;

    return $rs->ofLabel($label)->first();
  }

  public function pricingTier($pricing_id, Request $request)
  {
    return (new ResourcePricingRepository)->findById($pricing_id)->tiers()->get();
  }

  public function selected($resource_id, $start, $end, Request $request)
  {
    $nights = Carbon::parse($start)->diffInDays(Carbon::parse($end));

    $rs = new ResourceRepository;

    $resource = $rs->with(['pricing.season'])->findById($resource_id);

    $days = [];

    foreach ($resource->pricing as $rate)
    {
      $overlap = datesOverlap($rate->season->sea_from, $rate->season->sea_to, $start, $end);

      if ($overlap > 0) {
        $days[] = [
          'price' => (int) $rate->rpr_price,
          'nights' => $overlap,
          'description' => $resource->rs_name
        ];
      }
    }

    if ($nights > array_sum(array_column($days, 'nights'))) {
      $days[] = [
        'price' => (int) $resource->rs_price,
        'nights' => $nights - array_sum(array_column($days, 'nights')),
        'description' => $resource->rs_name
      ];
    }

    return collect(['resource' => $resource, 'days' => $days]);
  }

  public function types()
  {
    return (new ResourceTypeRepository)->get();
  }

  public function subTypes($rty_id)
  {
    // dd(ResourceSubType::getDropDown($rty_id));
    return ResourceSubType::getDropDown($rty_id);
    // return ResourceSubType::where('rsty_type', '=', $rty_id)->where('rsty_status', '=', 'active')->get();
  }

}

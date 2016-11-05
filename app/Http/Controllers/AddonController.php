<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Booking;
use App\Bill;
use App\Resource;
use App\ResourceType;
use App\ResourceFilter;
use Repositories\AddonRepository;
use Repositories\ResourceRepository;
use Repositories\BillItemRepository;

class AddonController extends MainController
{
  protected $repo;

  public function __construct(AddonRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  public function create(Request $request, Bill $bill, ResourceType $resource_type)
  {
    $input = $request->input();

    $this->layout = 'layouts.modal';

    $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);

    $filters = new ResourceFilter(['status' => 'active', 'type' => $resource_type->rty_id]);

    $booking = $bill->booking;

    $resources = (new ResourceRepository)->getDropDown($filters);

    $this->vdata(compact('bill', 'booking', 'resource_type', 'resources'));

    return view('addon.new_basic', $this->vdata);
  }

  public function createPos(Request $request, Bill $bill, ResourceType $resource_type)
  {
    $input = $request->input();

    $this->layout = 'layouts.modal';

    $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);

    $filters = new ResourceFilter(['status' => 'active', 'type' => $resource_type->rty_id]);

    $booking = $bill->booking;

    $resources = (new ResourceRepository)->get($filters);

    $this->vdata(compact('bill', 'booking', 'resource_type', 'resources'));

    return view('addon.new_pos', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    DB::transaction(function() use($input) {

      $this->repo->store($input);

      $resource = (new ResourceRepository)->findById(array_get($input, 'add_resource'));

      $gross = $resource->rs_price * array_get($input, 'add_unit');

      (new BillItemRepository)->store([
        'bili_resource' => $resource->rs_id,
        'bili_description' => $resource->rs_name,
        'bili_bill' => array_get($input, 'add_bill'),
        'bili_unit_price' => $resource->rs_price,
        'bili_unit' => array_get($input, 'add_unit'),
        'bili_gross' => $gross,
        'bili_tax' => calcTax($gross),
      ]);
    });

    return $this->goodReponse();
  }

  public function push(Request $request, Booking $booking, Resource $resource)
  {
    session()->push($booking->book_id . '.pos', $resource->rs_id);

    return $this->goodReponse(trans('form.item_added', ['item' => $resource->rs_name]));
  }

}

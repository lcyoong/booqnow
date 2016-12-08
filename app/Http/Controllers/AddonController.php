<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
// use App\Booking;
// use App\Bill;
// use App\Resource;
// use App\ResourceType;
use Filters\ResourceFilter;
use Repositories\AddonRepository;
use Repositories\ResourceRepository;
use Repositories\BillItemRepository;
use Repositories\BookingRepository;
use Repositories\BillRepository;
use Repositories\ResourceTypeRepository;

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

  public function create(Request $request, $book_id, $rty_id)
  {
    $booking = (new BookingRepository)->findById($book_id);

    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $input = $request->input();

    $this->layout = 'layouts.modal';

    $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);

    $account_bill = array_column($booking->bills->toArray(), 'bil_id', 'bil_accounting');

    $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->getDropDown('rs_id', 'rs_name');

    $this->vdata(compact('bill', 'booking', 'resource_type', 'resources', 'account_bill'));

    return view('addon.new_basic', $this->vdata);
  }

  public function createPos(Request $request, $book_id, $rty_id)
  {
    $booking = (new BookingRepository)->findById($book_id);

    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $input = $request->input();

    $this->layout = 'layouts.modal';

    $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);

    // $filters = new ResourceFilter(['status' => 'active', 'type' => $resource_type->rty_id]);

    $account_bill = array_column($booking->bills->toArray(), 'bil_id', 'bil_accounting');

    $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->get();

    $this->vdata(compact('bill', 'booking', 'resource_type', 'resources', 'account_bill'));

    return view('addon.new_pos', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    DB::transaction(function() use($input) {

      $resource = (new ResourceRepository)->findById(array_get($input, 'add_resource'));

      $accounting = $resource->resourceType->accounting;

      if (empty($input['add_bill'])) {

        $booking = (new BookingRepository)->findById(array_get($input, 'add_booking'));

        $new_bill = (new BillRepository)->store([
          'bil_customer' => array_get($input, 'add_customer'),
          'bil_accounting' => $accounting->acc_id,
          'bil_booking' => array_get($input, 'add_booking'),
          'bil_description' => $accounting->acc_bill_description,
          'bil_date' => date('Y-m-d'),
          'bil_due_date' => date('Y-m-d'),
        ]);

        $input['add_bill'] = $new_bill->bil_id;
      }

      $this->repo->store($input);

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

  public function storeList(Request $request)
  {
    $input = $request->input();

    DB::transaction(function() use($input) {

      foreach( $input['addon_id'] as $id => $content) {

        $item = json_decode($content);

        $unit = 1;

        $gross = $item->rs_price * $unit;

        (new BillItemRepository)->store([
          'bili_resource' => $id,
          'bili_description' => $item->rs_name,
          'bili_bill' => array_get($input, 'add_bill'),
          'bili_unit_price' => $item->rs_price,
          'bili_unit' => $unit,
          'bili_gross' => $gross,
          'bili_tax' => calcTax($gross),
        ]);
      }
    });

    return $this->goodReponse();
  }

  public function push(Request $request, $book_id, $rs_id)
  {
    $resource = (new ResourceRepository)->findById($rs_id);

    session()->push($book_id . '.pos', $resource);

    return $this->goodReponse(trans('form.item_added', ['item' => $resource->rs_name]));
  }

  public function pop(Request $request, $book_id)
  {
    return session()->get($book_id . '.pos');
  }

}

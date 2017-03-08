<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use Repositories\AddonRepository;
use Repositories\ResourceRepository;
use Repositories\BillItemRepository;
use Repositories\BookingRepository;
use Repositories\BillRepository;
use Repositories\ResourceTypeRepository;

class AddonController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param AddonRepository $repo
   */
  public function __construct(AddonRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  /**
   * Display new addon form.
   * @param  Request $request
   * @param  int  $book_id  booking id
   * @param  int  $rty_id   resource type id
   * @param  boolean $pos   POS mode on/off
   * @return Response
   */
  public function create(Request $request, $book_id, $rty_id, $pos = false)
  {
    $booking = (new BookingRepository)->findById($book_id);

    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $input = $request->input();

    $this->layout = 'layouts.modal';

    $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);

    $account_bill = array_column($booking->bills->toArray(), 'bil_id', 'bil_accounting');

    if ($pos) {
      $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->get();
    } else {
      $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->getDropDown('rs_id', 'rs_name');
    }

    $this->vdata(compact('bill', 'booking', 'resource_type', 'resources', 'account_bill'));

    return view($pos ? 'addon.new_pos' : 'addon.new_basic', $this->vdata);
  }

  /**
   * Display new addon form in POS form
   * @param  Request $request
   * @param  int  $book_id  booking id
   * @param  int  $rty_id   resource type id
   * @return Response
   */
  public function createPos(Request $request, $book_id, $rty_id)
  {
    return $this->create($request, $book_id, $rty_id, true);
  }

  /**
   * Process storing of new addon
   * @param  Request $request
   * @return Response
   */
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
          'bil_date' => today('Y-m-d'),
          'bil_due_date' => today('Y-m-d'),
        ]);

        $input['add_bill'] = $new_bill->bil_id;
      }

      $this->createBillItem($resource, $input);

      $this->repo->store($input);
    });

    return $this->goodReponse();
  }

  /**
   * Process storing of new addon list
   * @param  Request $request
   * @return Response
   */
  public function storeList(Request $request)
  {
    $input = $request->input();

    DB::transaction(function() use($input) {

      foreach( $input['addon_id'] as $content) {

        $item = json_decode($content);

        $this->createBillItem($item, $input);
      }
    });

    return $this->goodReponse();
  }

  /**
   * Create bill item
   * @param  int $id    Bill id
   * @param  App\Resources $item
   * @param  array $input Input from user form
   * @return Response
   */
  private function createBillItem($item, $input)
  {
    $unit = array_get($input, 'add_unit', 1);

    $unit_price = array_get($input, 'add_price', $item->rs_price);

    // $gross = $unit_price * $unit;

    return (new BillItemRepository)->store([
      'bili_resource' => $item->rs_id,
      'bili_description' => $item->rs_name,
      'bili_bill' => array_get($input, 'add_bill'),
      'bili_unit_price' => $unit_price,
      'bili_unit' => $unit,
      // 'bili_gross' => $gross,
      // 'bili_tax' => calcTax($gross),
    ]);
  }

  /**
   * Push addon into queue
   * @param  Request $request
   * @param  int  $book_id Booking id
   * @param  int  $rs_id   Resource id
   * @return Response
   */
  public function push(Request $request, $book_id, $rs_id)
  {
    $resource = (new ResourceRepository)->findById($rs_id);

    session()->push($book_id . '.pos', $resource);

    return $this->goodReponse(trans('form.item_added', ['item' => $resource->rs_name]));
  }

  /**
   * Remove addon from queue
   * @param  Request $request
   * @param  int  $book_id Booking id
   * @return Response
   */
  public function pop(Request $request, $book_id)
  {
    return session()->get($book_id . '.pos');

    return $this->goodReponse(trans('form.item_removed', ['item' => $resource->rs_name]));
  }

}

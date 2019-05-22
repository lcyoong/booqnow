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
use Repositories\AgentRepository;
use Carbon\Carbon;

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
    // public function create(Request $request, $book_id, $rty_id, $pos = false)
    // {
    //   $booking = (new BookingRepository)->findById($book_id);
    //
    //   $resource_type = (new ResourceTypeRepository)->findById($rty_id);
    //
    //   $input = $request->input();
    //
    //   $this->layout = 'layouts.modal';
    //
    //   $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);
    //
    //   $account_bill = array_column($booking->bills->toArray(), 'bil_id', 'bil_accounting');
    //
    //   if ($pos) {
    //     $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->get();
    //   } else {
    //     $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->getDropDown('rs_id', 'rs_name');
    //   }
    //
    //   $this->vdata(compact('bill', 'booking', 'resource_type', 'resources', 'account_bill'));
    //
    //   return view($pos ? 'addon.new_pos' : 'addon.new_basic', $this->vdata);
    // }
    public function create($rty_id, $pos, $reload_on_complete = 'false')
    {
        $agents = $this->agents('suppliers');

        $this->vdata(compact('agents', 'reload_on_complete'));

        return view($pos ? 'addon.new_pos' : 'addon.new_basic', $this->vdata);
    }

    private function prepareResource($rty_id, $pos)
    {
        $resource_type = (new ResourceTypeRepository)->findById($rty_id);

        $this->page_title = trans('addon.new', ['type' => $resource_type->rty_name]);

        if ($pos) {
            $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->get();
        } else {
            $resources = (new ResourceRepository)->ofStatus('active')->ofType($resource_type->rty_id)->getDropDown('rs_id', 'rs_name');
        }

        $this->vdata(compact('resource_type', 'resources'));
    }

    public function createForBooking(Request $request, $rty_id, $book_id, $pos = false)
    {
        $booking = (new BookingRepository)->findById($book_id);

        $this->prepareResource($rty_id, $pos);

        $this->layout = 'layouts.modal';

        $resource_type = array_get($this->vdata, 'resource_type');

        $add_to_bill = array_get(array_column($booking->bills->toArray(), 'bil_id', 'bil_accounting'), $resource_type->rty_accounting);

        $this->vdata(compact('booking', 'account_bill', 'add_to_bill'));

        return $this->create($rty_id, $pos);
    }

    /**
     * New add-on for walk-in bill
     * @param  Request $request [description]
     * @param  [type]  $rty_id  [description]
     * @param  [type]  $bil_id  [description]
     * @param  boolean $pos     [description]
     * @return [type]           [description]
     */
    public function createForBill(Request $request, $rty_id, $bil_id, $pos = false)
    {
        $bill = (new BillRepository)->findById($bil_id);

        $this->prepareResource($rty_id, $pos);

        $this->layout = 'layouts.modal';

        $add_to_bill = $bill->bil_id;

        $this->vdata(compact('bill', 'add_to_bill'));

        return $this->create($rty_id, $pos, 'true');
    }

    /**
     * Edit add-on for walk-in bill
     * @param  Request $request [description]
     * @param  [type]  $rty_id  [description]
     * @param  [type]  $bil_id  [description]
     * @param  boolean $pos     [description]
     * @return [type]           [description]
     */
    public function editForBill(Request $request, $bili_id, $pos = false)
    {
        $agents = $this->agents('suppliers');

        $item = (new BillItemRepository)->findById($bili_id);

        $addon = $item->addon;

        $resource_type = $item->resource->resourceType;

        $this->page_title = trans('addon.edit', ['item' => $item->resource->rs_name . " ($addon->add_customer_name)"]);

        $this->layout = 'layouts.modal';

        $this->vdata(compact('item', 'agents', 'resource_type', 'addon'));

        return view('addon.edit_single_item', $this->vdata);
    }

    /**
     * Edit add-on
     * @param  Request $request [description]
     * @param  [type]  $rty_id  [description]
     * @param  [type]  $bil_id  [description]
     * @param  boolean $pos     [description]
     * @return [type]           [description]
     */
    public function edit(Request $request, $add_id)
    {
        $agents = $this->agents('suppliers');

        $addon = (new AddonRepository)->findById($add_id);

        $resource_type = $addon->resource->resourceType;

        $this->page_title = trans('addon.edit', ['item' => $addon->resource->rs_name . " ($addon->add_customer_name)"]);

        $this->layout = 'layouts.modal';

        $this->vdata(compact('agents', 'resource_type', 'addon'));

        return view('addon.edit_single_item', $this->vdata);
    }

    /**
     * Display new addon form in POS form
     * @param  Request $request
     * @param  int  $book_id  booking id
     * @param  int  $rty_id   resource type id
     * @return Response
     */
    // public function createPos(Request $request, $book_id, $rty_id)
    // {
    //   return $this->create($request, $book_id, $rty_id, true);
    // }

    /**
     * Process storing of new addon
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->input();

        DB::transaction(function () use ($input) {
            $resource = (new ResourceRepository)->findById(array_get($input, 'add_resource'));

            $accounting = $resource->resourceType->accounting;

            $booking = (new BookingRepository)->findById(array_get($input, 'add_booking'));

            if (empty($input['add_to_bill'])) {
                $new_bill = (new BillRepository)->store([
                    'bil_customer' => array_get($input, 'add_customer'),
                    'bil_customer_name' => array_get($input, 'bil_customer_name'),
                    'bil_accounting' => $accounting->acc_id,
                    'bil_booking' => array_get($input, 'add_booking'),
                    'bil_description' => $accounting->acc_bill_description,
                    'bil_date' => today('Y-m-d'),
                    'bil_due_date' => today('Y-m-d'),
                    // 'bil_date' => today('Y-m-d'),
                    // 'bil_due_date' => today('Y-m-d'),
                    'bil_date' => Carbon::parse($booking->book_from)->format('Y-m-d'),
                    'bil_due_date' => Carbon::parse($booking->book_from)->format('Y-m-d'),
                    ]);

                $input['add_to_bill'] = $new_bill->bil_id;
            }

            $new_bill_item = $this->createBillItem($resource, $input, $booking);

            $input['add_bill_item'] = $new_bill_item->bili_id;

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

        DB::transaction(function () use ($input) {
            $bill = (new BillRepository)->findById(array_get($input, 'add_to_bill'));

            foreach ($input['addon_id'] as $content) {
                $item = json_decode($content);

                $new_bill_item = $this->createBillItem($item, $input, $bill->booking);

                $input['add_bill_item'] = $new_bill_item->bili_id;
                $input['add_resource'] = $item->rs_id;
                $input['add_date'] = date('YmdHis');
                $input['add_pax'] = $item->rs_pax;
                $input['add_unit'] = $item->rs_unit;

                $this->repo->store($input);
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
    private function createBillItem($item, $input, $booking)
    {
        // $unit = array_get($input, 'add_unit', 1);

        $unit = array_get($input, 'add_pax', 1) + array_get($input, 'add_pax_child', 0);

        $unit_price = array_get($input, 'add_price', $item->rs_price);

        return (new BillItemRepository)->store([
            'bili_resource' => $item->rs_id,
            'bili_description' => $item->rs_name,
            'bili_bill' => array_get($input, 'add_to_bill'),
            'bili_unit_price' => $unit_price,
            'bili_unit' => isset($item->rs_unit) ? $item->rs_unit : $unit,
            'bili_date' => array_get($input, 'add_date'),
            'bili_with_tax' => array_get($input, 'add_with_tax', in_array($booking->book_source, explode(',', env('SOURCES_WITHOUT_VAT'))) ? 0 : 1),
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

    /**
     * Process updating of addon
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->repo->update($request->input(), $addon);

        if ($addon->bill_item) {
            $addon->bill_item->update(['bili_active' => ($addon->add_status == 'cancelled') ? 0 : 1]);
        }

        return $this->goodReponse();
    }

    /**
     * Return agents list
     * @return array
     */
    private function agents($type)
    {
        return (new AgentRepository)->ofType($type)->getDropDown('ag_id', 'ag_name');
    }
}

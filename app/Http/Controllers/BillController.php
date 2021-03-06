<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BillRepository;
use Repositories\CountryRepository;
use Repositories\BillItemRepository;
use Filters\BillFilter;
use DB;
use PDF;
use Reports\BillExportExcel;
use App\Bill;
use Carbon\Carbon;

class BillController extends MainController
{
    protected $repo;

    /**
     * Create a new controller instance.
     * @param BillRepository $repo
     */
    public function __construct(BillRepository $repo)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->tenant = true;
    }

    /**
     * Display bill list
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filters = new BillFilter($request->input());

        $this->filter = $request->input();

        $this->page_title = trans('bill.list');

        $list = $this->repo->getPages($filters);

        $this->new_path = urlTenant('bills/new');

        $this->new_path_attr = "v-modal";

        $this->vdata(compact('list'));

        return view('bill.list', $this->vdata);
    }

    /**
     * Display walkin bill list
     * @param  Request $request
     * @return Response
     */
    public function walkin(Request $request)
    {
        $input = $request->input();

        $input['walkin'] = true;

        $filters = new BillFilter($input);

        $this->filter = $input;

        $this->page_title = trans('bill.list_walkin');

        $list = $this->repo->getPages($filters);

        $this->new_path = urlTenant('bills/new');

        $this->new_path_attr = "v-modal";

        $filter_url = "bills/walkin";

        $this->vdata(compact('list', 'filter_url'));

        return view('bill.list', $this->vdata);
    }

    /**
     * Display single bill
     * @param  int $bil_id Bill id
     * @return Response
     */
    public function view($bil_id)
    {
        $bill = $this->repo->findById($bil_id);

        $this->layout = 'layouts.modal';

        $this->page_title = trans('bill.view', ['id' => $bill->display_id]);

        $this->vdata(compact('bill'));

        return view('bill.view', $this->vdata);
    }

    /**
     * Display the new bill form
     * @return Response
     */
    public function create()
    {
        $this->page_title = trans('bill.new');

        $this->layout = 'layouts.modal';

        return view('bill.new_type', $this->vdata);
    }

    /**
     * Display edit bill form
     * @param  int $id - Bill id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $redirect_to_date = $request->redirect_to_date;
        // $bill = $this->repo->findById($id);

        $this->page_title = trans('bill.edit', ['id' => $id]);

        // $this->layout = 'layouts.modal';

        $this->vdata(compact('id', 'redirect_to_date'));

        return view('bill.edit', $this->vdata);
    }

    /**
     * Display printed bill
     * @param  int $bil_id Bill id
     * @return Response
     */
    public function download($bil_id, $split = false)
    {
        $bill = $this->repo->findById($bil_id);

        $ref = "#" . $bill->display_id;

        $this->layout = 'layouts.print';

        $title = trans('bill.print_title', ['no' => '']);

        $items = $bill->getItems();

        $room_items = $bill->getRoomItems();

        $addon_items = $bill->getAddonItems()->groupBy('created_date_hour')->toArray();

        $indie_items = $bill->indieItems();

        $resource_name = array_column(array_get($this->vdata, 'resource_types')->toArray(), 'rty_name', 'rty_id');

        $this->vdata(compact('bill', 'title', 'items', 'room_items', 'addon_items', 'indie_items', 'resource_name', 'ref'));

        // Bills that is partially hidden from guests
        // if (array_search($bill->booking->book_source, explode(",", env('BILL_TYPE_GUEST_HIDDEN', '3,6'))) === false) {
        if ($split) {
            return @PDF::loadView('bill.print_split', $this->vdata)->stream(sprintf("bill-%s.pdf", $bill->bil_id));
        } else {
            return @PDF::loadView('bill.print', $this->vdata)->stream(sprintf("bill-%s.pdf", $bill->bil_id));
        }
    }

    /**
     * Display printed bill
     * @param  int $bil_id Bill id
     * @return Response
     */
    public function downloadPrintable($bil_id)
    {
        $bill = $this->repo->findById($bil_id);

        $ref = "#" . $bill->display_id;

        $this->layout = 'layouts.print';

        $title = trans('bill.print_title', ['no' => '']);

        $room_items = $bill->getRoomItems(1);

        $addon_items = $bill->getAddonItems(1)->groupBy('created_date_hour')->toArray();

        $indie_items = $bill->indieItems(1);

        $resource_name = array_column(array_get($this->vdata, 'resource_types')->toArray(), 'rty_name', 'rty_id');

        $this->vdata(compact('bill', 'title', 'room_items', 'addon_items', 'indie_items', 'resource_name', 'ref'));

        return @PDF::loadView('bill.print', $this->vdata)->stream(sprintf("bill-%s.pdf", $bill->bil_id));
    }

    /**
     * Print bill - with or without VAT
     * @param  int $bil_id Bill id
     * @return Response
     */
    public function downloadPrintVAT($bil_id, $vat = null)
    {
        $bill = $this->repo->findById($bil_id);

        $ref = "#" . $bill->display_id;

        $this->layout = 'layouts.print';

        $title = trans('bill.print_title', ['no' => '']);

        $items = $bill->getItems();

        $room_items = $bill->getRoomItems($vat);

        $addon_items = $bill->getAddonItems($vat)->groupBy('created_date_hour')->toArray();

        $indie_items = $bill->indieItems($vat);

        $resource_name = array_column(array_get($this->vdata, 'resource_types')->toArray(), 'rty_name', 'rty_id');

        $this->vdata(compact('bill', 'title', 'items', 'room_items', 'addon_items', 'indie_items', 'resource_name', 'ref', 'vat'));

        return @PDF::loadView('bill.print_vat', $this->vdata)->stream(sprintf("bill-%s.pdf", $bill->bil_id));
    }

    /**
     * Export data
     * @param  Request $request
     * @return Response
     */
    public function export(Request $request)
    {
        $filters = new BillFilter($request->input());

        $report = new BillExportExcel('bill');

        $report->filter($filters);

        $report->handle();

        return $this->goodReponse();
    }

    public function fetch(Request $request)
    {
        $filters = new BillFilter($request->input());

        $this->filter = $request->input();

        return $this->repo->getPages($filters);
    }

    /**
     * Process updating of bill
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->repo->update($request->input(), $bill);

        $this->repo->refreshGrossTax();

        return $this->goodReponse('Bill updated!', ['redirect_to' => Carbon::parse($bill->bil_date)->format('Y-m-d')]);
    }

    /**
     * Process storing of bill
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->repo->store($request->input());

        return $this->goodReponse();
    }

    /**
     * Process storing of walk-in bill
     * @param  Request $request
     * @return Response
     */
    public function storeWalkIn(Request $request)
    {
        $input = $request->input();

        $walkin = [
      'bil_accounting' => 1,
      'bil_customer_name' => array_get($input, 'bil_customer_name'),
      'bil_description' => trans('bill.walkin_default_description'),
      'bil_date' => today('Y-m-d'),
      'bil_due_date' => today('Y-m-d'),
    ];

        $result = $this->repo->store($walkin);

        return $this->goodReponse(null, ['bill' => $result]);
    }

    /**
     * Process storing of bill item
     * @param  Request $request
     * @return Response
     */
    public function storeItem(Request $request)
    {
        (new BillItemRepository)->store($request->input());

        return $this->goodReponse();
    }

    /**
     * Process updating of bill item
     * @param  Request $request
     * @return Response
     */
    public function updateItem(Request $request)
    {
        (new BillItemRepository)->update($request->input(), $bill_item);

        if ($bill_item->addon) {
            $bill_item->addon->update(['add_status' => ($bill_item->bili_active == 1) ? 'active' : 'cancelled']);
        }

        return $this->goodReponse();
    }

    /**
     * Untax bill
     * @param  Request $request
     * @return Response
     */
    public function untax(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);

        $bill->update(['bil_with_tax' => 0]);

        foreach ($bill->items as $item) {
            $item->update(['bili_with_tax' => 0]);
        }

        return $this->goodReponse();
    }

    /**
     * Tax bill
     * @param  Request $request
     * @return Response
     */
    public function tax(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);

        $bill->update(['bil_with_tax' => 1]);

        foreach ($bill->items as $item) {
            $item->update(['bili_with_tax' => 1]);
        }

        return $this->goodReponse();
    }
}

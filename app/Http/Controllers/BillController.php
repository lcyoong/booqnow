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

    $this->layout = 'layouts.tenant';
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

    $this->vdata(compact('list'));

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

    $this->page_title = trans('bill.view', ['id' => $bil_id]);

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

    return view('bill.new', $this->vdata);
  }

  /**
   * Display edit bill form
   * @param  int $id - Bill id
   * @return Response
   */
  public function edit($id)
  {
    // $bill = $this->repo->findById($id);

    $this->page_title = trans('bill.edit', ['id' => $id]);

    // $this->layout = 'layouts.modal';

    $this->vdata(compact('id'));

    return view('bill.edit', $this->vdata);
  }

  /**
   * Display printed bill
   * @param  int $bil_id Bill id
   * @return Response
   */
  public function download($bil_id)
  {
    $bill = $this->repo->findById($bil_id);

    $this->layout = 'layouts.print';

    $title = trans('bill.print_title', ['no' => '#' . $bill->bil_id]);

    $items = $bill->getItems();

    $resource_name = array_column(array_get($this->vdata, 'resource_types')->toArray(), 'rty_name', 'rty_id');

    $this->vdata(compact('bill', 'title', 'items', 'resource_name'));

    return PDF::loadView('bill.print', $this->vdata)->stream(sprintf("bill-%s.pdf", $bill->bil_id));
  }

  /**
   * Export data
   * @param  Request $request
   * @return Response
   */
  public function export(Request $request)
  {
    $filters = new BillFilter($request->input());

    dd($filters);

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
    $this->repo->update($request->input());

    return $this->goodReponse();
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
    (new BillItemRepository)->update($request->input());

    return $this->goodReponse();
  }

}

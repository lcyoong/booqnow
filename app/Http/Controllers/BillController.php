<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BillRepository;
use Repositories\CountryRepository;
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

    $countries = (new CountryRepository)->getDropDown();

    $this->vdata(compact('countries'));
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

    $this->page_title = trans('bill.view', ['id' => $bill->bil_id]);

    $this->vdata(compact('bill'));

    return view('bill.view', $this->vdata);
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

}

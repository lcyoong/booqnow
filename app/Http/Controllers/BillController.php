<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BillRepository;
use Repositories\CountryRepository;
use Filters\BillFilter;
// use App\Bill;
use DB;
use PDF;

class BillController extends MainController
{
  protected $repo;

  public function __construct(BillRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $countries = (new CountryRepository)->getDropDown();

    $this->vdata(compact('countries'));
  }

  public function index(Request $request)
  {
    $filters = new BillFilter($request->input());

    $this->passFilter($request->input());

    $this->page_title = trans('bill.list');

    $list = $this->repo->getPages($filters);

    $this->vdata(compact('list'));

    return view('bill.list', $this->vdata);
  }

  public function view($bil_id)
  {
    $bill = $this->repo->findById($bil_id);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('bill.view', ['id' => $bill->bil_id]);

    $this->vdata(compact('bill'));

    return view('bill.view', $this->vdata);
  }

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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BillRepository;
use Repositories\CountryRepository;
use App\BillFilter;
use App\Bill;
use DB;

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

    $filter = $request->input();

    $this->page_title = trans('bill.list');

    $list = $this->repo->getPages($filters, [['table' => 'customers', 'left_col' => 'cus_id', 'right_col' => 'bil_customer']]);

    $this->vdata(compact('list', 'filter'));

    return view('bill.list', $this->vdata);
  }

  public function view(Bill $bill)
  {
    $this->layout = 'layouts.modal';

    $this->page_title = trans('bill.view', ['id' => $bill->bil_id]);

    $single = $this->repo->single($bill->bil_id);

    $customer = $single->customer;

    $this->vdata(compact('single', 'customer'));

    return view('bill.view', $this->vdata);
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// use App\Bill;
// use Repositories\CodeRepository;
use Repositories\ReceiptRepository;
use Repositories\BillRepository;
use Filters\ReceiptFilter;

class ReceiptController extends MainController
{
  protected $repo;

  public function __construct(ReceiptRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    // $pay_methods = (new CodeRepository)->getDropDown('pay_method');
    //
    // $this->vdata(compact('pay_methods'));
  }

  public function index(Request $request)
  {
    $filters = new ReceiptFilter($request->input());

    $filter = $request->input();

    $this->page_title = trans('receipt.list');

    $list = $this->repo->getPages($filters, [['table' => 'customers', 'left_col' => 'cus_id', 'right_col' => 'rc_customer']]);

    $this->vdata(compact('list', 'filter'));

    return view('receipt.list', $this->vdata);
  }

  public function create(Request $request, $bil_id)
  {
    $bill = (new BillRepository)->findById($bil_id);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('receipt.new');

    $this->vdata(compact('bill'));

    return view('receipt.new', $this->vdata);
  }

  public function store(Request $request)
  {
    $this->repo->store($request->input());

    return $this->goodReponse();
  }

}

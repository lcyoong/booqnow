<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Bill;
use Repositories\CodeRepository;
use Repositories\ReceiptRepository;

class ReceiptController extends MainController
{
  protected $repo;

  public function __construct(ReceiptRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    $pay_methods = (new CodeRepository)->getDropDown('pay_method');

    $this->vdata(compact('pay_methods'));
  }

  public function create(Request $request, Bill $bill)
  {
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

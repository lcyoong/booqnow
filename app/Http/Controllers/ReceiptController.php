<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\ReceiptRepository;
use Repositories\BillRepository;
use Filters\ReceiptFilter;

class ReceiptController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param ReceiptRepository $repo
   */
  public function __construct(ReceiptRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;
  }

  /**
   * Display receipts list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filters = new ReceiptFilter($request->input());

    $filter = $request->input();

    $this->page_title = trans('receipt.list');

    $list = $this->repo->getPages($filters);

    $this->vdata(compact('list', 'filter'));

    return view('receipt.list', $this->vdata);
  }

  /**
   * Display a new payment form
   * @param  Request $request
   * @param  int  $bil_id - Bill id
   * @return Response
   */
  public function create(Request $request, $bil_id)
  {
    $bill = (new BillRepository)->findById($bil_id);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('receipt.new') . " {$bill->display_id}";

    $this->vdata(compact('bill'));

    return view('receipt.new', $this->vdata);
  }

  /**
   * Display edit receipt form
   * @param  int $id - Receipt id
   * @return Response
   */
  public function edit($id)
  {
    $receipt = $this->repo->findById($id);

    $this->page_title = trans('receipt.edit');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('receipt'));

    return view('receipt.edit', $this->vdata);
  }

  /**
   * Process storing of receipt
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $this->repo->store($request->input());

    return $this->goodReponse();
  }

  /**
   * Process updating of receipt
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $this->repo->update($request->input());

    return $this->goodReponse();
  }

}

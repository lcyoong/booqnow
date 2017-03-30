<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\ExpenseRepository;
use Repositories\ExpenseCategoryRepository;
use Filters\ExpenseFilter;

class ExpenseController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param ExpenseRepository $repo_cus
   */
  public function __construct(ExpenseRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    $category = (new ExpenseCategoryRepository)->getDropDown('exc_id', 'exc_name');

    $this->vdata(compact('category'));
  }

  /**
   * Display list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filters = new ExpenseFilter($request->input());

    $this->filter = $request->input();

    $this->page_title = trans('expense.list');

    $this->new_path = urlTenant('expenses/new');

    $this->new_path_attr = "v-modal";

    $list = $this->repo->getPages($filters);

    $this->vdata(compact('list'));

    return view('expense.list', $this->vdata);
  }

  /**
   * Display the new expense form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('expense.new');

    $this->layout = 'layouts.modal';

    return view('expense.new', $this->vdata);
  }

  /**
   * Display edit form
   * @param  int $id - Expense id
   * @return Response
   */
  public function edit($id)
  {
    $expense = $this->repo->findById($id);

    $this->page_title = trans('expense.edit');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('expense', 'id'));

    return view('expense.edit', $this->vdata);
  }

  /**
   * Process storing of new record
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $new = $this->repo->store($request->input());

    return $this->goodReponse();
  }

  /**
   * Process updating of record
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $this->repo->update($request->input());

    return $this->goodReponse();
  }

}

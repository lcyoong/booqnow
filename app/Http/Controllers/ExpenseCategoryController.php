<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\ExpenseCategoryRepository;
use Filters\ExpenseCategoryFilter;

class ExpenseCategoryController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param ExpenseCategoryRepository $repo_cus
   */
  public function __construct(ExpenseCategoryRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;
  }

  /**
   * Display list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filters = new ExpenseCategoryFilter($request->input());

    $this->filter = $request->input();

    $this->page_title = trans('expense_category.list');

    $this->new_path = urlTenant('expenses_category/new');

    $this->new_path_attr = "v-modal";

    $list = $this->repo->getPages($filters);

    $this->vdata(compact('list'));

    return view('expense_category.list', $this->vdata);
  }

  /**
   * Display the new expense category form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('expense_category.new');

    $this->layout = 'layouts.modal';

    return view('expense_category.new', $this->vdata);
  }

  /**
   * Display edit form
   * @param  int $id - Expense category id
   * @return Response
   */
  public function edit($id)
  {
    $category = $this->repo->findById($id);

    $this->page_title = trans('expense_category.edit');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('category'));

    return view('expense_category.edit', $this->vdata);
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

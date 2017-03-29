<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use Repositories\PermissionRepository;
use App\Http\Controllers\MainController;

class PermissionController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param UserRepository $repo
   */
  public function __construct(PermissionRepository $repo)
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
    $this->page_title = trans('permission.list');

    $list = $this->repo->getPages();

    $this->new_path = urlTenant('permissions/new');

    $this->new_path_attr = "v-modal";

    $this->vdata(compact('list'));

    return view('permission.list', $this->vdata);

  }

  /**
   * Display the new role form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('permission.new');

    $this->layout = 'layouts.modal';

    return view('permission.new', $this->vdata);
  }

  /**
   * Display edit form
   * @param  int $id - Role id
   * @return Response
   */
  public function edit($id)
  {
    $permission = $this->repo->findById($id);

    $this->page_title = trans('permission.edit');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('permission', 'id'));

    return view('permission.edit', $this->vdata);
  }

  /**
   * Process storing of role
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $this->repo->store($request->input());

    return $this->goodReponse();
  }

  /**
   * Process updating
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $this->repo->update($request->input());

    return $this->goodReponse();
  }

}

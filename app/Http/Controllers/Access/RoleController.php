<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use Repositories\RoleRepository;
use Repositories\PermissionRepository;
use App\Http\Controllers\MainController;
use App\Permission;
use Auth;

class RoleController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param UserRepository $repo
   */
  public function __construct(RoleRepository $repo)
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
    // $filters = new UserFilter($request->input());
    //
    // $this->filter = $request->input();

    $this->page_title = trans('role.list');

    $list = $this->repo->getPages();

    $this->new_path = urlTenant('roles/new');

    $this->new_path_attr = "v-modal";

    $this->vdata(compact('list'));

    return view('role.list', $this->vdata);

  }

  /**
   * Display the new role form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('role.new');

    $this->layout = 'layouts.modal';

    return view('role.new', $this->vdata);
  }

  /**
   * Display edit form
   * @param  int $id - Role id
   * @return Response
   */
  public function edit($id)
  {
    $role = $this->repo->findById($id);

    $this->page_title = trans('role.edit', ['name' => $role->display_name]);

    $this->layout = 'layouts.modal';

    $this->vdata(compact('role', 'id'));

    return view('role.edit', $this->vdata);
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

  /**
   * Display permission list form
   * @param  Request $request
   * @return Response
   */
  public function permission(Request $request, $id)
  {
    $this->repo->findById($id);

    $list = Permission::leftJoin('permission_role', function ($join) use($id) {
      $join->on('permission_id', '=', 'id')->where('role_id', '=', $id);
    })->get();

    $this->page_title = trans('role.permission');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('list', 'id'));

    return view('role.permission', $this->vdata);
  }

  /**
   * Attach new permission to role
   * @param Request $request
   * @param integer  $role
   * @param integer  $permission
   */
  public function addPermission(Request $request, $role, $permission)
  {
    $this->repo->findById($role)->permissions()->attach($permission);

    return $this->goodReponse();
  }

  /**
   * Sync permission to role
   * @param Request $request
   * @param integer  $role
   * @param integer  $permission
   */
  public function syncPermission(Request $request, $role)
  {
    $input = $request->input();

    $permission = array_get($input, 'toggled', []);

    // $this->repo->findById($role)->permissions()->sync(array_keys($permission));
    $this->repo->findById($role)->perms()->sync(array_keys($permission));

    return $this->goodReponse();
  }

}

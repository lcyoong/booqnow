<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\MainController;
use Repositories\UserRepository;
use Repositories\RoleRepository;
use Filters\UserFilter;

class UserController extends MainController
{
    protected $repo;

    /**
     * Create a new controller instance.
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo)
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
        // dd(auth()->user()->hasRole('super_admin'));
        $filters = new UserFilter($request->input());

        $this->filter = $request->input();

        $this->page_title = trans('user.list');

        $list = $this->repo->with(['roles'])->getPages($filters);

        $this->new_path = urlTenant('users/new');

        $this->new_path_attr = "v-modal";

        $this->vdata(compact('list'));

        return view('user.list', $this->vdata);
    }

    /**
     * Display new form
     * @return Response
     */
    public function create()
    {
        $this->page_title = trans('user.new');

        $roles = (new RoleRepository)->getDropDown('id', 'display_name');

        $this->layout = 'layouts.modal';

        $this->vdata(compact('roles'));

        return view('user.new', $this->vdata);
    }

    /**
     * Display edit form
     * @param  int $id - User id
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->repo->findById($id);

        $roles = (new RoleRepository)->getDropDown('id', 'display_name');

        $this->page_title = trans('user.edit', ['name' => $user->name]);

        $this->layout = 'layouts.modal';

        $this->vdata(compact('user', 'id', 'roles'));

        return view('user.edit', $this->vdata);
    }

    /**
     * Process storing of user
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $merchant = session('merchant');

        // $temp_password = str_random(8);

        // $input['password'] = bcrypt($temp_password);

        $input['api_token'] = str_random(60);

        $user = $this->repo->store($input);

        $role = array_get($input, 'role', []);

        // $merchantUser = $user->merchantUser()->create(['mus_merchant' => $merchant->mer_id, 'mus_user' => $user->id]);

        $user->roles()->sync([$role]);

        return $this->goodReponse();
    }

    /**
     * Process updating
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $input = $request->input();

        $input['status'] = $request->has('status');

        \Log::info($input);

        $user = $this->repo->findById(array_get($input, 'id'));

        $this->repo->update($input);

        $role = array_get($input, 'role', []);

        $user->roles()->sync([$role]);

        return $this->goodReponse();
    }
}

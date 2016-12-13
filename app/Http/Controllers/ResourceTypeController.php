<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\ResourceTypeRepository;
use Filters\ResourceFilter;

class ResourceTypeController extends MainController
{
  protected $repo_rty;

  /**
   * Create a new controller instance.
   * @param ResourceTypeRepository $repo_rty [description]
   */
  public function __construct(ResourceTypeRepository $repo_rty)
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $this->repo_rty = $repo_rty;
  }

  /**
   * Display resource types list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filters = new ResourceFilter($request->input());

    $this->page_title = trans('resource_type.list');

    $resource_types = $this->repo_rty->getPages($filters);

    $this->vdata(compact('resource_types'));

    return view('resource_type.list', $this->vdata);
  }

  /**
   * Display the new resource type form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('resource_type.new');

    return view('resource_type.new', $this->vdata);
  }

  /**
   * Display the edit resource type form
   * @param  int  $rty_id - Resource type id
   * @return Response
   */
  public function edit($rty_id)
  {
    $resource_type = $this->repo_rty->findById($rty_id);

    $this->page_title = trans('resource_type.edit');

    $this->vdata(compact('resource_type'));

    return view('resource_type.edit', $this->vdata);
  }

  /**
   * Process storing of new resource type
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $this->repo_rty->store($request->input());

    return $this->goodReponse();
  }

  /**
   * Process updating of a resource type
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $this->repo_rty->update($request->input());

    return $this->goodReponse();
  }

  // protected function validation($request)
  // {
  //   $this->validate($request, [
  //     'rty_name' => 'required|max:255',
  //     'rty_price' => 'required|numeric',
  //   ]);
  // }

}

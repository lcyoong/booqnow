<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\StoreResourceSubType;
use Repositories\ResourceSubTypeRepository;
use App\ResourceSubType;

class ResourceSubTypeController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param ResourceSubTypeRepository $repo [description]
   */
  public function __construct(ResourceSubTypeRepository $repo)
  {
    parent::__construct();

    $this->tenant = true;

    $this->repo = $repo;
  }

  /**
   * Display resource types list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $this->page_title = trans('resource_sub_type.list');

    $resource_sub_types = ResourceSubType::paginate();

    $this->page_title = trans('resource_sub_type.list');

    $this->new_path = urlTenant('resource_sub_types/new');

    $this->vdata(compact('resource_sub_types'));

    return view('resource_sub_type.list', $this->vdata);
  }

  /**
   * Display the new resource type form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('resource_sub_type.new');

    return view('resource_sub_type.new', $this->vdata);
  }

  /**
   * Display the edit resource type form
   * @param  int  $rty_id - Resource type id
   * @return Response
   */
  public function edit($rty_id)
  {
    $resource_sub_type = $this->repo->findById($rty_id);

    $this->page_title = trans('resource_sub_type.edit');

    $this->vdata(compact('resource_sub_type'));

    return view('resource_sub_type.edit', $this->vdata);
  }

  /**
   * Process storing of new resource type
   * @param  Request $request
   * @return Response
   */
  public function store(StoreResourceSubType $request)
  {
    ResourceSubType::create($request->input());

    return $this->goodReponse();
  }

  /**
   * Process updating of a resource type
   * @param  Request $request
   * @return Response
   */
  public function update(StoreResourceSubType $request)
  {
    $sub_type = ResourceSubType::findOrFail($request->rsty_id);

    $sub_type->update($request->input());

    return $this->goodReponse();
  }
}

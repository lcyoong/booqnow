<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ResourceSubType;
use Repositories\ResourceRepository;
use Repositories\ResourceTypeRepository;
use Filters\ResourceFilter;

class ResourceController extends MainController
{
  protected $repo_rs;

  /**
   * Create a new controller instance.
   * @param ResourceRepository $repo_rs
   */
  public function __construct(ResourceRepository $repo_rs)
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $this->repo_rs = $repo_rs;
  }

  /**
   * Display resources list
   * @param  Request $request
   * @param  int  $rty_id - Resource type id
   * @return Response
   */
  public function index(Request $request, $rty_id)
  {
    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $filters = new ResourceFilter($request->input() + ['type' => $resource_type->rty_id]);

    $filter = $request->input();

    $this->page_title = trans('resource.list', ['type' => $resource_type->rty_plural]);

    $this->new_path = urlTenant(sprintf('resources/%s/new', $resource_type->rty_id));

    $resources = $this->repo_rs->getPages($filters, 'asc');

    $this->vdata(compact('resources', 'filter', 'resource_type'));

    return view('resource.list', $this->vdata);
  }

  /**
   * Display the new resource form
   * @param  int $rty_id - Resource type id
   * @return Response
   */
  public function create($rty_id)
  {
    $sub_types = ResourceSubType::getDropDown($rty_id);

    $resource_type = (new ResourceTypeRepository)->findById($rty_id);

    $this->page_title = trans('resource.new', ['type' => $resource_type->rty_name]);

    $this->vdata(compact('resource_type', 'sub_types'));

    return view('resource.new', $this->vdata);
  }

  /**
   * Display the edit resource form
   * @param  int  $rs_id - Resource id
   * @return Response
   */
  public function edit($rs_id)
  {
    $resource = $this->repo_rs->findById($rs_id);

    $sub_types = ResourceSubType::getDropDown($resource->rs_type);

    $resource_type = (new ResourceTypeRepository)->findById($resource->rs_type);

    $this->page_title = trans('resource.edit', ['type' => $resource_type->rty_name]);

    $this->vdata(compact('resource', 'resource_type', 'sub_types'));

    return view('resource.edit', $this->vdata);
  }

  /**
   * Process storing of new resource
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $input = $request->input();

    $this->repo_rs->store($input);

    return $this->goodReponse();
  }

  /**
   * Process updating of a resource
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $input = $request->input();

    $this->repo_rs->update($input);

    return $this->goodReponse();
  }

}

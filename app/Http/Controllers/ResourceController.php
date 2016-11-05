<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Resource;
use App\ResourceType;
use App\Merchant;
use Repositories\ResourceRepository;
use Repositories\ResourceTypeRepository;
use App\ResourceFilter;

class ResourceController extends MainController
{
  protected $repo_rs;

  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $this->repo_rs = (new ResourceRepository);
  }

  public function index(Request $request, ResourceType $resource_type)
  {
    $filters = new ResourceFilter($request->input() + ['type' => $resource_type->rty_id]);

    $filter = $request->input();

    $this->page_title = trans('resource.list', ['type' => $resource_type->rty_plural]);
    // $this->page_title = $resource_type->rty_name;

    $this->new_path = urlTenant(sprintf('resources/%s/new', $resource_type->rty_id));

    $resources = $this->repo_rs->getPages($filters, [], 'asc');

    $this->vdata(compact('resources', 'filter', 'resource_type'));

    return view('resource.list', $this->vdata);
  }

  public function create(ResourceType $resource_type)
  {
    $this->page_title = trans('resource.new', ['type' => $resource_type->rty_name]);

    $this->vdata(compact('resource_type'));

    return view('resource.new', $this->vdata);
  }

  public function edit(Merchant $merchant, Resource $resource)
  {
    $resource_type = (new ResourceTypeRepository)->findById($resource->rs_type);

    $this->page_title = trans('resource.edit', ['type' => $resource_type->rty_name]);

    $this->vdata(compact('resource', 'resource_type'));

    return view('resource.edit', $this->vdata);
  }

  public function store(Request $request)
  {
    // $this->validation($request);
    //
    $input = $request->input();

    $this->repo_rs->store($input);

    return $this->goodReponse();
  }

  public function update(Request $request)
  {
    // $this->validation($request);

    $input = $request->input();

    $this->repo_rs->update($input);

    return $this->goodReponse();
  }

  // public function active()
  // {
  //   dd('sss');
  //   $filters = new ResourceFilter(['status' => 'active']);
  //
  //   dd($this->repo_rs->get($filters));
  //
  //   return $this->repo_rs->getPages($filters);
  // }

  // protected function validation($request)
  // {
  //   $this->validate($request, [
  //     'rs_name' => 'required|max:255',
  //     'rs_price' => 'required|numeric',
  //   ]);
  // }

}

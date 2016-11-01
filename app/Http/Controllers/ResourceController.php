<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Resource;
use App\Merchant;
use Repositories\ResourceRepository;
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

  public function index(Request $request)
  {
    $filters = new ResourceFilter($request->input());

    $filter = $request->input();

    $this->page_title = trans('resource.list');

    $this->new_path = urlTenant('resources/new');

    $resources = $this->repo_rs->getPages($filters, [], 'asc');

    $this->vdata(compact('resources', 'filter'));

    return view('resource.list', $this->vdata);
  }

  public function create()
  {
    $this->page_title = trans('resource.new');

    return view('resource.new', $this->vdata);
  }

  public function edit(Merchant $merchant, Resource $resource)
  {
    $this->page_title = trans('resource.edit');

    $this->vdata(compact('resource'));

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

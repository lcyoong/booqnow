<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// use App\ResourceType;
// use App\Merchant;
use Repositories\ResourceTypeRepository;
use Filters\ResourceFilter;

class ResourceTypeController extends MainController
{
  protected $repo_rty;

  public function __construct(ResourceTypeRepository $repo_rty)
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $this->repo_rty = $repo_rty;
  }

  public function index(Request $request)
  {
    $filters = new ResourceFilter($request->input());

    $this->page_title = trans('resource_type.list');

    $resource_types = $this->repo_rty->getPages($filters);

    $this->vdata(compact('resource_types'));

    return view('resource_type.list', $this->vdata);
  }

  public function create()
  {
    $this->page_title = trans('resource_type.new');

    return view('resource_type.new', $this->vdata);
  }

  public function edit($rty_id)
  {
    $resource_type = $this->repo_rty->findById($rty_id);

    $this->page_title = trans('resource_type.edit');

    $this->vdata(compact('resource_type'));

    return view('resource_type.edit', $this->vdata);
  }

  public function store(Request $request)
  {
    $this->validation($request);

    $input = $request->input();

    $this->repo_rty->store($input);

    return $this->goodReponse();
  }

  public function update(Request $request)
  {
    $this->validation($request);

    $input = $request->input();

    $this->repo_rty->update($input);

    return $this->goodReponse();
  }

  protected function validation($request)
  {
    $this->validate($request, [
      'rty_name' => 'required|max:255',
      'rty_price' => 'required|numeric',
    ]);
  }

}

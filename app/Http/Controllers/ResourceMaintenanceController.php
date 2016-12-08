<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// use App\Resource;
// use App\ResourceMaintenance;
use Repositories\ResourceTypeRepository;
use Repositories\ResourceRepository;
use Repositories\ResourceMaintenanceRepository;
use Filters\ResourceMaintenanceFilter;

class ResourceMaintenanceController extends MainController
{
  protected $repo;

  public function __construct(ResourceMaintenanceRepository $repo)
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $this->repo = $repo;
  }

  public function create($rs_id)
  {
    $resource = (new ResourceRepository)->findById($rs_id);

    $resource_type = (new ResourceTypeRepository)->findById($resource->rs_type);

    $filters = new ResourceMaintenanceFilter(['resource' => $resource->rs_id]);

    $maintenance_list = $this->repo->get($filters);

    $this->page_title = trans('resource.maintenance', ['type' => $resource_type->rty_name]);

    $this->vdata(compact('resource', 'resource_type', 'maintenance_list'));

    return view('resource.maintenance', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    $this->repo->store($input);

    return $this->goodReponse();
  }

  public function delete($rs_id, $rm_id)
  {
    $resource = (new ResourceRepository)->findById($rs_id);

    $this->repo->deleteById($rm_id);

    return $this->goodReponse();
  }

}

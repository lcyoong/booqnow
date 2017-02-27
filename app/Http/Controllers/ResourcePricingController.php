<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\ResourcePricingRepository;
use Repositories\ResourceRepository;
use Repositories\SeasonRepository;

class ResourcePricingController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param ResourcePricingRepository $repo
   */
  public function __construct(ResourcePricingRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  /**
   * Display pricing list
   * @param  Request $request
   * @return Response
   */
  public function index($resource, Request $request)
  {
    $resource = (new ResourceRepository)->findById($resource);

    $this->filter = $request->input();

    $this->page_title = trans('resource_pricing.list');

    // $list = $resource->pricing;

    $seasons = (new SeasonRepository)->getDropDown('sea_id', 'season_text', 'seasons');

    $this->vdata(compact('resource', 'seasons'));

    return view('resource_pricing.list', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    $this->repo->store($input);

    return $this->goodReponse();
  }

  public function delete($rpr_id)
  {
    $this->repo->deleteById($rpr_id);

    return $this->goodReponse();
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\ResourcePricingRepository;
use Repositories\ResourcePricingTierRepository;

class ResourcePricingTierController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param ResourcePricingRepository $repo
   */
  public function __construct(ResourcePricingTierRepository $repo)
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
  public function index($pricing_id, Request $request)
  {
    $this->layout = 'layouts.modal';

    $pricing = (new ResourcePricingRepository)->findById($pricing_id);

    $this->page_title = trans('resource_pricing.tier');

    $this->vdata(compact('pricing', 'pricing_id'));

    return view('resource_pricing.tier', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    $this->repo->store($input);

    return $this->goodReponse();
  }

  public function delete($rpt_id)
  {
    $this->repo->deleteById($rpt_id);

    return $this->goodReponse();
  }

}

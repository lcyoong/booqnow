<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filters\CountryFilter;
use App\Country;

class CountryController extends MainController
{
  /**
   * Create a new controller instance.
   * @param AgentRepository $repo
   */
  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;
  }

  /**
   * Display list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filters = new CountryFilter($request->input());

    $this->filter = $request->input();

    $this->page_title = trans('country.list');

    $list = Country::filter($filters)->paginate();

    $this->vdata(compact('list'));

    return view('country.list', $this->vdata);
  }

  /**
   * Display edit form
   * @param  int $id - Agent id
   * @return Response
   */
  public function edit($id)
  {
    $country = Country::findOrFail($id);

    $this->page_title = trans('country.edit');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('country', 'id'));

    return view('country.edit', $this->vdata);
  }

  /**
   * Process updating of record
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $country = Country::findOrFail($request->id);

    $country->update($request->input());

    return $this->goodReponse();
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\AgentRepository;
use Filters\AgentFilter;

class AgentController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param AgentRepository $repo
   */
  public function __construct(AgentRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;
  }

  /**
   * Display list
   * @param  Request $request
   * @return Response
   */
  public function index(Request $request)
  {
    $filters = new AgentFilter($request->input());

    $this->filter = $request->input();

    $this->page_title = trans('agent.list');

    $this->new_path = urlTenant('agents/new');

    $this->new_path_attr = "v-modal";

    $list = $this->repo->getPages($filters);

    $this->vdata(compact('list'));

    return view('agent.list', $this->vdata);
  }

  /**
   * Display the new agent form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('agent.new');

    $this->layout = 'layouts.modal';

    return view('agent.new', $this->vdata);
  }

  /**
   * Display edit form
   * @param  int $id - Agent id
   * @return Response
   */
  public function edit($id)
  {
    $agent = $this->repo->findById($id);

    $this->page_title = trans('agent.edit');

    $this->layout = 'layouts.modal';

    $this->vdata(compact('agent', 'id'));

    return view('agent.edit', $this->vdata);
  }

  /**
   * Process storing of new record
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $this->repo->store($request->input());

    return $this->goodReponse();
  }

  /**
   * Process updating of record
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $this->repo->update($request->input());

    return $this->goodReponse();
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\CommentRepository;

class CommentController extends MainController
{
  protected $repo;

  /**
   * Create a new controller instance.
   * @param BillRepository $repo
   */
  public function __construct(CommentRepository $repo)
  {
    parent::__construct();

    $this->repo = $repo;

    $this->tenant = true;
  }

  public function get(Request $request, $type, $id)
  {
    // $comments = $this->repo->where('com_model_type', '=', $type)->where('com_model_id', '=', $id)->get();
    $this->layout = 'layouts.modal';

    $this->page_title = trans('comment.list');

    $this->vdata(compact('id', 'type'));

    return view('comment.view', $this->vdata);
  }

  public function store(Request $request)
  {
    // $input = $request->input() + ['com_model' => (new)];
    $input = $request->input();

    $this->repo->store($input);

    return $this->goodReponse();
  }

}

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

  public function store(Request $request)
  {
    // $input = $request->input() + ['com_model' => (new)];

    $this->repo->store($input);

    return $this->goodReponse();
  }

}

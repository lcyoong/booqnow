<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\CommentFilter;
use DB;

class CommentRepository extends BaseRepository {

  /**
   * Create a new repository instance.
   */
  public function __construct()
  {
    $this->filter = new CommentFilter();

    parent::__construct('App\Comment');

    $this->rules = [
      'com_content' => 'required|min:10',
    ];
  }
}

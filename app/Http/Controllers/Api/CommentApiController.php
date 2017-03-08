<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\CommentRepository;
use Filters\CommentFilter;

class CommentApiController extends ApiController
{
  public function get($type, $id)
  {
    $filters = new CommentFilter(['modelType' => $type, 'modelId' => $id]);

    return (new CommentRepository)->with(['creator'])->get($filters, null, ['com_id' => 'desc']);
  }
}

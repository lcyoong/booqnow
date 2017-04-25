<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\AgentRepository;
use Filters\AgentFilter;
use Carbon\Carbon;

class AgentApiController extends ApiController
{
  protected $repo;

  public function __construct(AgentRepository $repo)
  {
    $this->repo = $repo;
  }

  public function get($type = 'agents')
  {
    $filters = new AgentFilter(['type' => $type]);

    $list = $this->repo->get($filters);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = ['id' => $item->ag_id, 'text' => $item->ag_name];
    }

    return $return;
  }
}

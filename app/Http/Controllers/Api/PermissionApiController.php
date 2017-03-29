<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\PermissionRepository;

class PermissionApiController extends ApiController
{
  protected $repo;

  public function __construct(PermissionRepository $repo)
  {
    $this->repo = $repo;
  }

  /**
   * Get active permissions
   * @param  Request $request
   * @return array
   */
   public function active(Request $request)
   {
     return $this->repo->get();
   }
}

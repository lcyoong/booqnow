<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\BillRepository;
use Filters\BillFilter;

class BillApiController extends ApiController
{
  protected $repo_bil;

  public function __construct(BillRepository $repo_bil)
  {
    $this->repo_bil = $repo_bil;
  }

  /**
   * Get active bookings for given parameters
   * @param  Request $request
   * @return array
   */
   public function get(Request $request)
   {
     $filters = new BillFilter($request->input());

     return $this->repo_bil->filter($filters)->with(['customer'])->getPages();
   }

}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Repositories\RoleRepository;
use App\Permission;

class RoleApiController extends ApiController
{
  protected $repo;

  public function __construct(RoleRepository $repo)
  {
    $this->repo = $repo;
  }

  /**
   * Get active permissions
   * @param  Request $request
   * @return array
   */
   public function permissions(Request $request, $id)
   {
     $role = $this->repo->findById($id);

     $list = Permission::select(DB::raw("display_name, id, name, if(role_id is null, 0, 1) as active"))->leftJoin('permission_role', function ($join) use($id) {
       $join->on('permission_id', '=', 'id')->where('role_id', '=', $id);
     })->get();

     $parsed_list = [];

     foreach ($list as $item) {
       $parsed_item = $item;
       $parsed_item->active = $item->active == 1 ? true : false;
       $parsed_list[] = $parsed_item;
     }

     return $parsed_list;
    //  return $role->permissions;
   }

}

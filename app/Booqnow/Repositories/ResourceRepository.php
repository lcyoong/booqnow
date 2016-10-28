<?php

namespace Repositories;

use App\Resource;
use DB;

class ResourceRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Resource');

    $this->rules = [
      'rs_name' => 'required|max:255',
      'rs_price' => 'required|numeric',      
    ];
  }

  // public function getList($filters)
  // {
  //   return Resource::filter($filters)->orderBy('rs_name', 'asc')->paginate(5);
  // }
  //
  // public function store($input)
  // {
  //   DB::beginTransaction();
  //
  //   Resource::create($input);
  //
  //   DB::commit();
  // }
  //
  // public function update($input)
  // {
  //   $resource = Resource::findOrFail(array_get($input, 'rs_id'));
  //
  //   $resource->update($input);
  // }

}

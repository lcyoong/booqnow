<?php

namespace Booqlee\Repositories;

use App\ResourceType;
use DB;

class ResourceTypeRepository {

  public function getList()
  {
    return ResourceType::all();
  }

  public function store($input)
  {
    DB::beginTransaction();

    ResourceType::create($input);

    DB::commit();
  }

  public function update($input)
  {
    $resource_type = ResourceType::findOrFail(array_get($input, 'rty_id'));

    $resource_type->update($input);
  }
}

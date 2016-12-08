<?php

namespace Repositories;

interface TestRepository extends 
{
  public function all($columns = ['*']);

  public function paginate($perPage = 15, $columns = ['*']);
}

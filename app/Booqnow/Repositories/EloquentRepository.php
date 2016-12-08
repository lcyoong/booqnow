<?php

namespace Repositories;

use Illuminate\Http\Request;
use Contracts\BaseRepositoryInterface;

class EloquentRepository implements BaseRepositoryInterface
{
  protected $repo;

  public function __construct($class)
  {
    $this->repo = new $class();
  }

  public function all($columns = ['*'])
  {
    return $this->repo->get($columns);
  }

  public function paginate($perPage = 15, $columns = ['*'])
  {
    return $this->repo->paginate($perPage, $columns);
  }

}

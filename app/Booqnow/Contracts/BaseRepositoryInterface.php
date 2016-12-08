<?php

namespace Contracts;

use Illuminate\Http\Request;
use App\Customer;
use DB;

interface BaseRepositoryInterface
{
  public function all($columns = ['*']);

  public function paginate($perPage = 15, $columns = ['*']);

}

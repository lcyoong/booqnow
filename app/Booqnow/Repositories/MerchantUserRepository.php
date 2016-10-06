<?php

namespace Booqnow\Repositories;

use App\MerchantUser;
use DB;

class MerchantUserRepository {

  public function getList()
  {
    return MerchantUser::with('user')->get();
  }

  public function store($input)
  {
    DB::beginTransaction();

    MerchantUser::create($input);

    DB::commit();
  }
}

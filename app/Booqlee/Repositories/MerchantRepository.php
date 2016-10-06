<?php

namespace Booqlee\Repositories;

use App\Merchant;
use DB;

class MerchantRepository {

  public function getList()
  {
    return Merchant::mine()->with('subscription.plan')->get();
  }

  public function store($input)
  {
    DB::beginTransaction();

    Merchant::create($input);

    DB::commit();
  }

  public function update($input)
  {
    $merchant = Merchant::findOrFail(array_get($input, 'mer_id'));

    $merchant->update($input);
  }
}

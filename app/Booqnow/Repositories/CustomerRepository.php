<?php

namespace Repositories;

// use App\Customer;
// use Illuminate\Http\Request;
use Filters\CustomerFilter;
use DB;

class CustomerRepository extends BaseRepository {

  public function __construct()
  {
    parent::__construct('App\Customer');

    $this->filter = new CustomerFilter();

    $this->rules = [
      'cus_first_name' => 'required|max:255',
      'cus_last_name' => 'required|max:255',
      'cus_country' => 'required',
      'cus_email' => 'required|email',
    ];
  }

  // public function getList($filters)
  // {
  //   return Customer::filter($filters)->get();
  // }
  //
  // public function store($input)
  // {
  //   DB::beginTransaction();
  //
  //   Customer::create($input);
  //
  //   DB::commit();
  // }
  //
  // public function update($input)
  // {
  //   $resource_type = Customer::findOrFail(array_get($input, 'cus_id'));
  //
  //   $resource_type->update($input);
  // }
  //
  // public function filter($filters)
  // {
  //   return Customer::filter($filters);
  // }
}

<?php

namespace Repositories;

use Filters\CustomerFilter;
use DB;
use App\Comment;

class CustomerRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
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
}

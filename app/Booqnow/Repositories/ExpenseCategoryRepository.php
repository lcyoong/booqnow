<?php

namespace Repositories;

use Illuminate\Http\Request;
use DB;

class ExpenseCategoryRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\ExpenseCategory');

    $this->rules = [
      'exc_name' => 'required',
    ];
  }
}

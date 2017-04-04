<?php

namespace Repositories;

use Illuminate\Http\Request;
use Filters\ExpenseCategoryFilter;
use DB;

class ExpenseCategoryRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    $this->filter = new ExpenseCategoryFilter();

    parent::__construct('App\ExpenseCategory');

    $this->rules = [
      'exc_name' => 'required',
    ];
  }

  /**
   * Filter only active categories
   * @return Repository
   */
  public function isActive()
  {
    $this->filter->add(['status' => 'active']);

    return $this;
  }

}

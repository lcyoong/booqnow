<?php

namespace Repositories;

use Illuminate\Http\Request;
use DB;

class ExpenseRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\Expense');

    $this->rules = [
      'exp_description' => 'required',
      'exp_category' => 'required|exists:expense_categories,exc_id',
      'exp_date' => 'required|date',
      'exp_account' => 'required',
    ];
  }
}

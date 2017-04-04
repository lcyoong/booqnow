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
      'exp_amount' => 'required|numeric|min:0.01',
      'exp_account' => 'required',
    ];
  }

  public function sumByMonthCategory($year)
  {
    return $this->repo->select(DB::raw("exp_category, month(exp_date) as mth, sum(exp_amount) as total"))
                ->join('expense_categories', 'exc_id', '=', 'exp_category')
                ->groupBy(DB::raw("exp_category, month(exp_date)"))->get();
  }

}

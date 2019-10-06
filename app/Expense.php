<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;
use Carbon\Carbon;

class Expense extends TenantModel
{
  use AuditTrailRelationship;
  use CommentRelationship;

  protected $audit = true;

  protected $primaryKey = 'exp_id';

  protected $fillable = ['exp_name', 'exp_date', 'exp_description', 'exp_category', 'exp_account', 'exp_amount', 'exp_memo', 'exp_status', 'created_by', 'exp_method', 'exp_payable'];

  /**
   * Mutator to set the formatted date
   * @param string $value
   */
  public function setExpDateAttribute($value)
  {
      $this->attributes['exp_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Accessor to get the formatted date
   * @param string $value
   */
  public function getExpDateAttribute($value)
  {
      return Carbon::parse($value)->format('d-m-Y');
  }

  /**
   * Get the category belonging to an expense
   */
  public function category()
  {
    return $this->belongsTo(ExpenseCategory::class, 'exp_category');
  }
}

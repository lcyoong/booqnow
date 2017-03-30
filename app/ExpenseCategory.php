<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;

class ExpenseCategory extends TenantModel
{
  use AuditTrailRelationship;

  protected $audit = true;

  protected $primaryKey = 'exc_id';

  protected $fillable = ['exc_name', 'exc_status', 'created_by'];

  /**
   * Get the expenses belonging to category
   */
  public function expenses()
  {
    return $this->hasMany(Expense::class, 'exp_category');
  }
}

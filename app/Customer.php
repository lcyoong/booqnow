<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;

class Customer extends TenantModel
{
  use AuditTrailRelationship;
  use CommentRelationship;

  protected $audit = true;

  protected $primaryKey = 'cus_id';

  protected $fillable = ['cus_first_name', 'cus_last_name', 'cus_email', 'cus_contact1', 'cus_contact2', 'cus_group', 'cus_address', 'cus_country', 'cus_status', 'created_by'];

  protected $appends = ['full_name'];

  /**
   * Mutator to get the full name of the customer
   * @param  [type] $value [description]
   * @return string
   */
  public function getFullNameAttribute()
  {
    return trim($this->cus_first_name . ' ' . $this->cus_last_name);
  }

  /**
   * Get the bills of the customer
   */
  public function bills()
  {
    return $this->hasMany(Bill::class, 'bil_customer');
  }

  /**
   * Get the LTV (Life Time Value) of the customer
   * @return decimal
   */
  public function ltv()
  {
    return $this->bills->sum('bil_gross');
  }

  // public function auditTrails()
  // {
  //   return $this->hasMany(AuditTrail::class, 'au_model_id')->where('au_model', '=', get_class($this))->orderBy('au_id', 'desc');
  // }

  // public function comments()
  // {
  //   return $this->hasMany(Comment::class, 'com_model_id')->where('com_model', '=', get_class($this))->orderBy('com_id', 'desc');
  // }

  public function saveComment($input)
  {
    $input['com_model'] = get_class($this);

    $comment = new Comment($input);

    $this->comments()->save($comment);
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;

class Receipt extends TenantModel
{
  use AuditTrailRelationship;
  use CommentRelationship;

  protected $audit = true;

  protected $primaryKey = 'rc_id';

  protected $fillable = ['rc_customer', 'rc_bill', 'rc_date', 'rc_amount', 'rc_remark', 'rc_intremark', 'rc_reference', 'rc_method', 'rc_status', 'created_by'];

  /**
   * Mutator to set the formatted receipt date
   * @param string $value
   */
  public function setRcDateAttribute($value)
  {
      $this->attributes['rc_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Accessor to get the formatted receipt date
   * @return numeric
   */
  public function getRcDateAttribute($value)
  {
    return Carbon::parse($value)->format('d-m-Y');
  }

  /**
   * Relationship with bill
   * @return Builder
   */
  public function bill()
  {
    return $this->belongsTo(Bill::class, 'rc_bill');
  }


  /**
   * Get the customer of the receipt
   */
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'rc_customer');
  }

  public static function boot()
  {
    parent::boot();

    Self::creating(function ($post) {

      $post->rc_customer = Bill::find($post->rc_bill)->customer->cus_id;

    });

    Self::created(function ($post) {

      // Bill::find($post->rc_bill)->refreshPaid();

    });

    Self::deleted(function ($post) {
    });

    Self::saved(function ($post) {

      Bill::find($post->rc_bill)->refreshPaid();

    });
  }

}

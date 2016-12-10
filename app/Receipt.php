<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Receipt extends TenantModel
{
  protected $primaryKey = 'rc_id';

  protected $fillable = ['rc_customer', 'rc_bill', 'rc_date', 'rc_amount', 'rc_remark', 'rc_intremark', 'rc_reference', 'rc_method', 'rc_status', 'created_by'];

  public function setRcDateAttribute($value)
  {
      $this->attributes['rc_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  public function customer()
  {
    return $this->belongsTo(Customer::class, 'rc_customer');
  }

  public static function boot()
  {
    parent::boot();

    static::creating(function ($post) {

      $post->rc_customer = Bill::find($post->rc_bill)->customer->cus_id;

    });

    static::created(function ($post) {

      Bill::find($post->rc_bill)->refreshPaid();

    });

    static::deleted(function ($post) {
      // Bill::find($post->bili_bill)->refreshGrossTax();

    });

    static::saved(function ($post) {
      Bill::find($post->rc_bill)->refreshPaid();

    });
  }

}

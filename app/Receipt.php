<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
  protected $primaryKey = 'rc_id';

  protected $fillable = ['rc_customer', 'rc_bill', 'rc_date', 'rc_amount', 'rc_remark', 'rc_intremark', 'rc_reference', 'rc_method', 'rc_status', 'created_by'];

  public static function boot()
  {
    parent::boot();

    static::creating(function ($post) {

      $post->rc_customer = Bill::find($post->rc_bill)->customer->cus_id;

    });

    static::deleted(function ($post) {

      // Bill::find($post->bili_bill)->refreshGrossTax();

    });

    static::saved(function ($post) {

      // Bill::find($post->bili_bill)->refreshGrossTax();

    });
  }

}

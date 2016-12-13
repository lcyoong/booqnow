<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillItem extends TenantModel
{
  protected $primaryKey = 'bili_id';

  protected $fillable = ['bili_bill', 'bili_description', 'bili_resource', 'bili_unit_price', 'bili_unit', 'bili_gross', 'bili_tax', 'bili_order', 'bili_status', 'created_by'];

  /**
   * Get the resource of the bill item
   */
  public function resource()
  {
    return $this->belongsTo(Resource::class, 'rs_type');
  }


  public static function boot()
  {
    parent::boot();

    static::deleted(function ($post) {

      Bill::find($post->bili_bill)->refreshGrossTax();

    });

    static::saved(function ($post) {

      Bill::find($post->bili_bill)->refreshGrossTax();

    });
  }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;

class BillItem extends TenantModel
{
  use AuditTrailRelationship;

  protected $audit = true;

  protected $primaryKey = 'bili_id';

  protected $fillable = ['bili_bill', 'bili_description', 'bili_resource', 'bili_unit_price', 'bili_unit', 'bili_gross', 'bili_tax', 'bili_order', 'bili_status', 'bili_active', 'created_by'];

  // protected $appends = ['on_off'];
  /**
   * Get the resource of the bill item
   */
  public function resource()
  {
    return $this->belongsTo(Resource::class, 'rs_type');
  }

  /**
   * Accessor to get the on/off status
   * @return numeric
   */
  public function getBiliActiveAttribute($value)
  {
    return $value == 1 ? true : false;
  }


  // /**
  //  * Accessor to set the gross amount
  //  * @return numeric
  //  */
  // public function setBiliGrossAttribute($value)
  // {
  //   $this->attributes['bili_gross'] = $this->attributes['bili_unit'] * $this->attributes['bili_unit_price'];
  // }


  public static function boot()
  {
    parent::boot();

    static::deleted(function ($post) {

      Bill::find($post->bili_bill)->refreshGrossTax();

    });

    static::saved(function ($post) {

      Bill::find($post->bili_bill)->refreshGrossTax();

    });

    static::saving(function ($post) {

      $post->bili_gross = $post->bili_unit * $post->bili_unit_price;

      $post->bili_tax = calcTax($post->bili_gross);

    });

  }

}

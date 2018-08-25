<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use Carbon\Carbon;

class BillItem extends TenantModel
{
  use AuditTrailRelationship;

  protected $audit = true;

  protected $primaryKey = 'bili_id';

  protected $fillable = ['bili_bill', 'bili_description', 'bili_resource', 'bili_unit_price', 'bili_unit', 'bili_gross', 'bili_tax', 'bili_with_tax', 'bili_order', 'bili_status', 'bili_active', 'created_by', 'bili_date'];

  protected $appends = ['created_date', 'created_date_hour'];

  /**
   * Mutator to set the formatted receipt date
   * @param string $value
   */
  public function setBiliDateAttribute($value)
  {
      $this->attributes['bili_date'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Get the bill of the bill item
   */
  public function bill()
  {
    return $this->belongsTo(Bill::class, 'bili_bill');
  }

  /**
   * Get the resource of the bill item
   */
  public function resource()
  {
    return $this->belongsTo(Resource::class, 'bili_resource');
  }

  /**
   * Get the corresponding add-on of the bill item (if any)
   */
  public function addon()
  {
    return $this->hasOne(Addon::class, 'add_bill_item');
  }

  /**
   * Accessor to bill item date
   * @return numeric
   */
  public function getBiliDateAttribute($value)
  {
    return !empty($value) ? Carbon::parse($value)->format('d-m-Y') : '';
  }

  /**
   * Accessor to get the on/off status
   * @return numeric
   */
  public function getBiliActiveAttribute($value)
  {
    return $value == 1 ? true : false;
  }

  /**
   * Accessor to get the on/off status
   * @return numeric
   */
  public function getCreatedDateAttribute($value)
  {
    return Carbon::parse($this->attributes['created_at'])->format('d-m-Y');
  }

  /**
   * Accessor to get the creation date/hour
   * @return numeric
   */
  public function getCreatedDateHourAttribute($value)
  {
    return Carbon::parse($this->attributes['created_at'])->format('d-m-Y:H');
  }

  public function scopeActive($query)
  {
    return $query->where('bili_active', '=', 1);
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

      if ($post->bill->bil_with_tax == 1) {

        $post->bili_tax = calcTax($post->bili_gross);

      } else {

        $post->bili_tax = 0;

      }

    });

  }

}

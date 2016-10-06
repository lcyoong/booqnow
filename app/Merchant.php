<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Events\MerchantCreated;

class Merchant extends BaseModel
{
  protected $primaryKey = 'mer_id';

  protected $fillable = ['mer_name', 'mer_country', 'mer_status', 'mer_owner', 'mer_connection', 'mer_setting', 'created_by'];

  public function scopeMine($query)
  {
    return $query->where('mer_owner', '=', auth()->user()->id);
  }

  public function subscription()
  {
    return $this->hasOne('App\Subscription', 'sub_merchant');
  }

  public function users()
  {
    return $this->hasMany('App\MerchantUser', 'mus_merchant');
  }

  public static function boot()
  {
    parent::boot();

    Merchant::creating(function($post)
    {
      $post->mer_owner = auth()->user()->id;

      $post->mer_connection = Self::formatConnection($post->mer_owner);
    });

    Merchant::created(function($post)
    {
      event(new MerchantCreated($post));
    });

  }

  private static function formatConnection($owner)
  {
    return $owner . '_' . Carbon::now()->format('YmdHis');
  }
}

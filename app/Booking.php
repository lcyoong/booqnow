<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;
use Carbon\Carbon;

class Booking extends TenantModel
{
  use AuditTrailRelationship;
  use CommentRelationship;

  protected $audit = true;

  protected $primaryKey = 'book_id';

  protected $fillable = ['book_resource', 'book_agent', 'book_customer', 'book_from', 'book_to', 'book_status', 'book_checkin', 'book_checkout', 'book_reference', 'book_tracking', 'book_pax', 'book_pax_child', 'book_source', 'book_remarks', 'book_special', 'book_expiry', 'book_lead_from', 'book_extra_bed', 'created_by'];

  protected $appends = ['display_id'];

  /**
   * Get the customer of the booking
   * @return Collection
   */
  public function customer()
  {
    return $this->belongsTo(Customer::class, 'book_customer');
  }

  /**
   * Get the agent of the booking
   * @return Collection
   */
  public function agent()
  {
    return $this->belongsTo(Agent::class, 'book_agent');
  }

  /**
   * Get the resource of the booking
   * @return Collection
   */
  public function resource()
  {
    return $this->belongsTo(Resource::class, 'book_resource');
  }

  /**
   * Get the bills of the booking
   * @return Collection
   */
  public function bills()
  {
    return $this->hasMany(Bill::class, 'bil_booking');
  }

  /**
   * Get the addons of the booking
   * @return Collection
   */
  public function addons()
  {
    return $this->hasMany(Addon::class, 'add_booking');
  }

  /**
   * Get the booking total bill outstanding amount
   * @return numeric
   */
  public function totalBillOS()
  {
    return $this->bills->sum('outstanding');
  }

  // public function scopeOfArrivalDate($query, $date)
  // {
  //   return $query->where('book_from', '=', $date);
  // }
  //
  // public function scopeOfDepartureDate($query, $date)
  // {
  //   return $query->where('book_to', '=', $date);
  // }

  /**
   * Check in the booking
   * @return void
   */
  public function checkIn()
  {
    $this->update(['book_status' => 'checkedin']);
  }

  /**
   * Check out the booking
   * @return void
   */
  public function checkOut()
  {
    $this->update(['book_status' => 'checkedout']);
  }

  /**
   * Mutator to set the agent field
   * @param string $value
   */
  public function setBookAgentAttribute($value)
  {
    $this->attributes['book_agent'] = empty($value) ? null : $value;
  }

  /**
   * Mutator to set the formatted booking from date
   * @param string $value
   */
  public function setBookFromAttribute($value)
  {
    $this->attributes['book_from'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Mutator to set the formatted booking to date
   * @param string $value
   */
  public function setBookToAttribute($value)
  {
    $this->attributes['book_to'] = Carbon::parse($value)->format('Y-m-d');
  }

  /**
   * Mutator to set the formatted date
   * @param string $value
   */
  public function setBookExpiryAttribute($value)
  {
    if (!empty($value)) {

      $this->attributes['book_expiry'] = Carbon::parse($value)->format('Y-m-d H:i:s');
      
    }
  }

  /**
   * Accessor to book date
   * @return string
   */
  public function getBookFromAttribute($value)
  {
    return Carbon::parse($value)->format('d-m-Y');
  }

  /**
   * Accessor to display id
   * @return string
   */
  public function getDisplayIdAttribute()
  {
    return "R" . $this->book_id;
  }

  /**
   * Accessor to book date
   * @return string
   */
  public function getBookToAttribute($value)
  {
    return Carbon::parse($value)->format('d-m-Y');
  }

  /**
   * Accessor to date field
   * @return string
   */
  public function getBookExpiryAttribute($value)
  {
    return !is_null($value) ? Carbon::parse($value)->format('d-m-Y H:i:s') : null;
  }

  public static function boot()
  {
    parent::boot();

    Self::saved(function ($post) {

      (new RoomOccupancy)->process($post->book_id, $post['original'], $post['attributes']);

    });
  }

}

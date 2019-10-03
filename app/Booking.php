<?php

namespace App;

use App\Events\BookingCancelled;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Events\BookingNightChanged;

class Booking extends TenantModel
{
    use AuditTrailRelationship;
    use CommentRelationship;

    protected $audit = true;

    protected $primaryKey = 'book_id';

    protected $fillable = ['book_resource', 'book_agent', 'book_customer', 'book_from', 'book_to', 'book_status', 'book_checkin', 'book_checkout', 'book_reference', 'book_tracking', 'book_pax', 'book_pax_child', 'book_source', 'book_remarks', 'book_special', 'book_expiry', 'book_lead_from', 'book_extra_bed', 'created_by', 'book_checkin_time', 'book_checkout_time'];

    protected $appends = ['display_id', 'book_pos'];

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
     * Get the room bill item
     */
    public function room_bill_item()
    {
        return $this->hasManyThrough(BillItem::class, 'App\Bill', 'bil_booking', 'bili_bill', 'book_id', 'bil_id')->whereHas('resource', function($query) {
            $query->where('rs_type', '=', 1);
        });
    }

    public function room()
    {
        return $this->hasOne(Resource::class, 'rs_id', 'book_resource');
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
     * Cancel the booking
     * @return void
     */
    public function cancel()
    {
        $this->update(['book_status' => 'cancelled']);
    }

    /**
     * Confirm the booking
     * @return void
     */
    public function confirm()
    {
        $this->update(['book_status' => 'confirmed']);
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
     * Mutator to set the formatted check in time
     * @param string $value
     */
    public function setBookCheckinTimeAttribute($value)
    {
        $this->attributes['book_checkin_time'] = Carbon::parse($value)->format('H:i:s');
    }

    /**
     * Mutator to set the formatted check out time
     * @param string $value
     */
    public function setBookCheckoutTimeAttribute($value)
    {
        $this->attributes['book_checkout_time'] = Carbon::parse($value)->format('H:i:s');
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
     * Accessor to POS
     * @return string
     */
    public function getBookPosAttribute()
    {
        return $this->resource->rs_name . " (" . $this->customer->full_name . ")";
    }

    /**
     * Accessor to check in time
     * @return string
     */
    public function getBookCheckinTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }

    /**
     * Accessor to check out time
     * @return string
     */
    public function getBookCheckoutTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
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

            // Booking cancelled
            if (array_get($post['original'], 'book_status') !== 'cancelled' && $post->book_status === 'cancelled') {
                event(new BookingCancelled($post));
            }
        });

        Self::updated(function ($model) {
            $original = $model->getOriginal();

            if ($original['book_from'] != $model->book_from || $original['book_to'] != $model->book_to) {
                event(new BookingNightChanged($model));
            }

        });
    }
}

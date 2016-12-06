<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingSource extends TenantModel
{
    protected $primaryKey = 'bs_id';
}

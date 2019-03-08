<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;
use Repositories\CountryRepository;

class Customer extends TenantModel
{
    use AuditTrailRelationship;
    use CommentRelationship;

    protected $audit = true;

    protected $primaryKey = 'cus_id';

    protected $fillable = ['cus_first_name', 'cus_last_name', 'cus_email', 'cus_contact1', 'cus_contact2', 'cus_group', 'cus_address', 'cus_country', 'cus_status', 'created_by'];

    protected $appends = ['full_name', 'full_country'];

    /**
     * Mutator to get the full name of the customer
     * @param  [type] $value [description]
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim(trim($this->cus_first_name) . ' ' . trim($this->cus_last_name));
    }

    public function getFullCountryAttribute()
    {
        $countries = (new CountryRepository)->getDropDown();

        return array_get($countries, $this->cus_country, 'N/A');
    }

    /**
     * Get the bills of the customer
     */
    public function bills()
    {
        return $this->hasMany(Bill::class, 'bil_customer');
    }

    /**
     * Get the LTV (Life Time Value) of the customer
     * @return decimal
     */
    public function ltv()
    {
        return $this->bills->sum('bil_gross');
    }
}

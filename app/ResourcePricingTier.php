<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\AuditTrailRelationship;

class ResourcePricingTier extends TenantModel
{
  use AuditTrailRelationship;

  protected $audit = true;

  protected $primaryKey = 'rpt_id';

  protected $fillable = ['rpt_pricing', 'rpt_from', 'rpt_to', 'rpt_price', 'created_by'];

  public function pricing()
  {
    return $this->belongsTo(ResourcePricing::class, 'rpt_pricing');
  }
}

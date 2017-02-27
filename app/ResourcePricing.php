<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;

class ResourcePricing extends TenantModel
{
  use AuditTrailRelationship;

  protected $audit = true;

  protected $primaryKey = 'rpr_id';

  protected $fillable = ['rpr_resource', 'rpr_season', 'rpr_from', 'rpr_to', 'rpr_price', 'created_by'];

  public function season()
  {
    return $this->belongsTo(Season::class, 'rpr_season');
  }
}

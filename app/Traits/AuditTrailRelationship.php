<?php
namespace App\Traits;

use App\AuditTrail;

trait AuditTrailRelationship
{
  public function auditTrails()
  {
    return $this->hasMany(AuditTrail::class, 'au_model_id')->where('au_model', '=', get_class($this))->orderBy('au_id', 'desc');
  }
}

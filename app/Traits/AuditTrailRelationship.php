<?php
namespace App\Traits;

use App\AuditTrail;

trait AuditTrailRelationship
{
  // public function auditTrails()
  // {
  //   return $this->hasMany(AuditTrail::class, 'au_model_id')->where('au_model', '=', get_class($this))->orderBy('au_id', 'desc');
  // }

  public function auditTrails()
  {
    // return $this->hasMany(Comment::class, 'com_model_id')->where('com_model', '=', get_class($this))->orderBy('com_id', 'desc');
    return $this->morphMany('App\AuditTrail', 'au_model')->orderBy('au_id', 'desc');
  }

}

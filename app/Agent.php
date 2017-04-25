<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditTrailRelationship;
use App\Traits\CommentRelationship;

class Agent extends TenantModel
{
  use AuditTrailRelationship;
  use CommentRelationship;

  protected $audit = true;

  protected $primaryKey = 'ag_id';

  protected $fillable = ['ag_name', 'ag_remarks', 'ag_status', 'ag_type', 'created_by'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResourceMaintenance extends TenantModel
{
  protected $primaryKey = 'rm_id';

  protected $fillable = ['rm_resource', 'rm_from', 'rm_to', 'rm_description', 'rm_status', 'created_by'];

  public function resource()
  {
    return $this->belongsTo(Resource::class, 'book_resource');
  }

  public static function boot()
  {
    parent::boot();

    static::creating(function ($post) {

      $post->rm_from = date('Y-m-d',strtotime($post->rm_from));

      $post->rm_to = date('Y-m-d',strtotime($post->rm_to));

    });
  }

}

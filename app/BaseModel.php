<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\ModelTrait;

class BaseModel extends Model
{
  use Notifiable;
  use ModelTrait;

  public static function boot()
  {
    Self::creating(function ($post) {

      $post->created_by = auth()->user()->id;

    });
  }
}

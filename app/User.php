<?php

namespace App;

use App\Events\UserCreated;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable, HasApiTokens;

  private $temp_password;
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = [
    'name', 'email', 'password', 'api_token'
  ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [
    'password', 'remember_token',
  ];

  public static function boot()
  {
    parent::boot();

    Self::creating(function ($post) {

      $temp_password = str_random(8);

      $post->password = bcrypt($temp_password);

    });

    Self::created(function ($post) {
      
      event(new UserCreated($post));

    });
  }  
}

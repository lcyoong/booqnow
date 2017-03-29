<?php

namespace Repositories;

use Illuminate\Http\Request;
use DB;
use Filters\UserFilter;

class UserRepository extends BaseRepository {

  /**
   * Create new repository instance
   */
  public function __construct()
  {
    parent::__construct('App\UserModel');

    $this->filter = new UserFilter();

    $this->rules = [
      'name' => 'required',
      'email' => 'required|unique:users,email',
      'role' => 'required',
    ];
  }

  protected function alt_rules()
  {
    return [
      'name' => 'required',
      'email' => 'required|unique_but_self:users,email,id',
      'role' => 'required',
    ];

  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DashboardController extends MainController
{
  public function merchant()
  {
    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    return view('dashboard.merchant', $this->vdata);
  }

  public function user()
  {
    return view('dashboard.user', $this->vdata);
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DashboardController extends MainController
{
    public function merchant()
    {
      return view('dashboard.merchant');
    }

    public function user()
    {
      return view('dashboard.user', $this->vdata);
    }

}

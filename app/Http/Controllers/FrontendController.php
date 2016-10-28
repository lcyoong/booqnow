<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class FrontendController extends MainController
{
  public function pick(Request $request)
  {
    $input = $request->input();

    session([
      'start' => array_get($input, 'start'),
      'end' => array_get($input, 'end'),
      'resource' => array_get($input, 'resource'),
    ]);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('customer.new');

    return view('customer.new_basic', $this->vdata);
  }
    
}

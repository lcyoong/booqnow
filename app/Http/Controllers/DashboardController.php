<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BookingRepository;
use Repositories\AddonRepository;

class DashboardController extends MainController
{
  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  // Front end display
  public function frontDesk()
  {
    return view('dashboard.reservation_chart', $this->vdata);
  }

  // Merchant display
  public function merchant(Request $request)
  {
    $input = $request->input();

    $date = array_get($input, 'date', date('Ymd'));

    $arrivals['today'] = (new BookingRepository)->ofArrivalDate($date)->get(5);

    $departures['today'] = (new BookingRepository)->ofDepartureDate($date)->get(5);

    $tours = (new AddonRepository)->ofDate($date)->ofType(2)->get();

    $this->vdata(compact('arrivals', 'departures', 'tours'));

    return view('dashboard.merchant', $this->vdata);
  }

  // public function user()
  // {
  //   return view('dashboard.user', $this->vdata);
  // }
}

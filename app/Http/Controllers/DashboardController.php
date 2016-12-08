<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BookingRepository;
use Repositories\AddonRepository;

class DashboardController extends MainController
{
  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  public function frontDesk()
  {
    return view('dashboard.reservation_chart', $this->vdata);
  }

  public function merchant(Request $request)
  {
    $input = $request->input();

    $date = array_get($input, 'date', date('Ymd'));

    $arrivals['today'] = (new BookingRepository)->ofArrivalDate($date, 5)->get();

    $departures['today'] = (new BookingRepository)->ofDepartureDate($date, 5)->get();

    $tours = (new AddonRepository)->ofDate($date)->ofType(2)->get();

    $this->vdata(compact('arrivals', 'departures', 'tours'));

    return view('dashboard.merchant', $this->vdata);
  }

  public function user()
  {
    return view('dashboard.user', $this->vdata);
  }
}

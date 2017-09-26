<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BookingRepository;
use Repositories\AddonRepository;
use Carbon\Carbon;

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
  public function frontDesk(Request $request)
  {
    $def_date = $request->date;

    // $def_date_alt = Carbon::parse($request->date)->format('m/d/Y');

    $this->vdata(compact('def_date', 'def_date_alt'));

    return view('dashboard.reservation_chart', $this->vdata);
  }

  // Merchant display
  public function merchant(Request $request)
  {
    $input = $request->input();

    $cdate = $date = array_get($input, 'date', date('d-m-Y'));

    // $cdate = Carbon::parse($date)->format('Ymd');

    $arrivals['today'] = (new BookingRepository)->ofArrivalDate($cdate)->get(null, 5);

    $departures['today'] = (new BookingRepository)->ofDepartureDate($cdate)->get(null, 5);

    $tours = (new AddonRepository)->ofDate($cdate)->ofType(2)->get();

    $transfers = (new AddonRepository)->ofDate($cdate)->ofType(4)->get();

    $this->vdata(compact('arrivals', 'departures', 'tours', 'transfers', 'date'));

    return view('dashboard.merchant', $this->vdata);
  }

  // public function user()
  // {
  //   return view('dashboard.user', $this->vdata);
  // }
}

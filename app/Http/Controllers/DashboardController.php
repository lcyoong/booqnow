<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Http\Requests;
use Filters\BookingFilter;
use Illuminate\Http\Request;
use Repositories\AddonRepository;
use Repositories\BookingRepository;

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
    public function daily(Request $request)
    {
        $input = $request->input();

        $cdate = $date = array_get($input, 'date', date('d-m-Y'));

        // $cdate = Carbon::parse($date)->format('Ymd');

        $arrivals['today'] = (new BookingRepository)->ofArrivalDate($cdate)->get();

        $departures['today'] = (new BookingRepository)->ofDepartureDate($cdate)->get();

        $tours = (new AddonRepository)->ofDate($cdate)->ofType(2)->get(null, 0, ['rs_name'=> 'asc']);

        $transfers = (new AddonRepository)->ofDate($cdate)->ofType(4)->get(null, 0, ['rs_name'=> 'asc']);

        $this->vdata(compact('arrivals', 'departures', 'tours', 'transfers', 'date'));

        return view('dashboard.merchant', $this->vdata);
    }

    public function expiringHold(Request $request)
    {
        $repo_book = new BookingRepository;

        $this->page_title = trans('nav.dashboard_hold');

        $filter['from_expiry_days'] = today();

        $filter['to_expiry_days'] = today();

        $filters = new BookingFilter($request->input() + ['status' => 'hold'] + $filter);

        $this->filter = $request->input();

        $list = $repo_book->filter($filters)->getPages();
        
        $this->vdata(compact('list'));

        return view('dashboard.expiring_hold', $this->vdata);
    }
}

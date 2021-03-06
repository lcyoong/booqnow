<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Filters\BookingFilter;
use Illuminate\Http\Request;
use Repositories\AgentRepository;
use Repositories\BillItemRepository;
use Repositories\BillRepository;
use Repositories\BookingRepository;
use Repositories\ResourceRepository;

class BookingController extends MainController
{
    protected $repo_book;

    /**
     * Create a new controller instance.
     * @param BookingRepository $repo_book
     */
    public function __construct(BookingRepository $repo_book)
    {
        parent::__construct();

        $this->repo_book = $repo_book;

        $this->tenant = true;
    }

    /**
     * Display bookings list
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filters = new BookingFilter($request->input());

        $this->filter = $request->input();

        $this->page_title = trans('booking.list');

        $list = $this->repo_book->filter($filters)->getPages();

        // $client = new Client();
        //
        // $resp = $client->get(url('api/v1/bookings'));
        //
        // $list = $resp->getBody()->getContents();
        //
        // $list = collect(json_decode($list));

        // dd(json_decode($list->getBody()->getContents()));

        $this->vdata(compact('list'));

        return view('booking.list', $this->vdata);
    }

    /**
     * Display new booking form
     * @param  Request $request
     * @param  int  $cus_id  Customer id
     * @return Response
     */
    public function create(Request $request, $cus_id = null)
    {
        // $customer = !is_null($cus_id) ? (new CustomerRepository)->findById($cus_id) : null;
        $customer = null;

        $input = $request->input();

        $slot = $this->selectedSlot($input);

        $agents = $this->agents('agents');

        $resource_id = array_get($slot, 'resource_id');

        $start = array_get($slot, 'start');

        $end = array_get($slot, 'end');

        $this->layout = 'layouts.modal';

        $this->page_title = trans('booking.new');

        $this->vdata(compact('customer', 'start', 'end', 'cus_id', 'resource_id', 'agents'));

        return view('booking.new_basic', $this->vdata);
    }

    /**
     * Display edit booking form
     * @param  int $id - Booking id
     * @return Response
     */
    public function edit(Request $request, $book_id)
    {
        $redirect_to_date = $request->redirect_to_date;

        $booking = $this->repo_book->findById($book_id);

        $rooms = (new ResourceRepository)->ofType(1)->ofStatus('active')->getDropDown('rs_id', 'rs_name');

        $agents = $this->agents('agents');

        $sales = $this->agents('sales');

        $this->page_title = trans('booking.edit', ['id' => $booking->display_id]);

        $this->vdata(compact('book_id', 'booking', 'rooms', 'agents', 'sales', 'redirect_to_date'));

        return view('booking.edit', $this->vdata);
    }

    /**
     * Process storing of new booking
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->input();

        DB::transaction(function () use ($input, &$new_booking) {
            $new_booking = $this->repo_book->store($input);

            $bili_bill = $this->createBill($input, $new_booking);

            $this->createBillItems($input, $bili_bill, $new_booking);

            $this->createExtras($input, $new_booking, $bili_bill);
        });

        return $this->goodReponse('Booking entered successfully', ['redirect_to' => Carbon::parse($new_booking->book_from)->format('Y-m-d')]);
    }

    /**
     * Process updating of booking
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->repo_book->update($request->input(), $booking);

        return $this->goodReponse('Booking updated!', ['redirect_to' => Carbon::parse($booking->book_from)->format('Y-m-d')]);
    }

    /**
     * Display the booking 'action' pop-up form
     * @param  int $book_id Booking id
     * @return Response
     */
    public function action($book_id)
    {
        $booking = $this->repo_book->findById($book_id);

        $this->layout = 'layouts.modal';

        $this->page_title = trans('booking.action', ['id' => $booking->display_id]);

        $bills = $booking->bills;

        $addons = $booking->addons;

        $this->vdata(compact('booking', 'bills', 'addons'));

        return view('booking.action', $this->vdata);
    }

    /**
     * Capture selected RC slot data
     * @param  array $input User input data
     * @return void
     */
    protected function selectedSlot($input)
    {
        // if (array_get($input, 'resource')) {
        //   session(['booking.resource' => (new ResourceRepository)->findById(array_get($input, 'resource'))]);
        // }
        if (array_get($input, 'resource')) {
            session(['booking.resource' => array_get($input, 'resource')]);
        }

        if (array_get($input, 'start')) {
            session(['booking.start' => array_get($input, 'start')]);
        }

        if (array_get($input, 'end')) {
            session(['booking.end' => array_get($input, 'end')]);
        }

        // $slot['resource'] =  session('booking.resource');
        $slot['start'] = session('booking.start');
        $slot['end'] = session('booking.end');
        $slot['resource_id'] = session('booking.resource');

        return $slot;
    }

    /**
     * Process check in of booking
     * @param  Request $request
     * @param  int  $book_id Booking id
     * @return Response
     */
    public function checkin(Request $request, $book_id)
    {
        $booking = $this->repo_book->findById($book_id);

        $booking->checkIn();

        return $this->goodReponse('Checked in', ['redirect_to' => Carbon::parse($booking->book_from)->format('Y-m-d')]);
    }

    /**
     * Process check out of booking
     * @param  Request $request
     * @param  int  $book_id Booking id
     * @return Response
     */
    public function checkout(Request $request, $book_id)
    {
        $booking = $this->repo_book->findById($book_id);

        $booking->checkOut();

        return $this->goodReponse('Checked out', ['redirect_to' => Carbon::parse($booking->book_from)->format('Y-m-d')]);
    }

    /**
     * Process cancel of booking
     * @param  Request $request
     * @param  int  $book_id Booking id
     * @return Response
     */
    public function cancel(Request $request, $book_id)
    {
        $booking = $this->repo_book->findById($book_id);

        $booking->cancel();

        return $this->goodReponse('Cancelled', ['redirect_to' => Carbon::parse($booking->book_from)->format('Y-m-d')]);
    }

    /**
     * Process confirm of booking
     * @param  Request $request
     * @param  int  $book_id Booking id
     * @return Response
     */
    public function confirm(Request $request, $book_id)
    {
        $booking = $this->repo_book->findById($book_id);

        $booking->confirm();

        return $this->goodReponse('Confirmed', ['redirect_to' => Carbon::parse($booking->book_from)->format('Y-m-d')]);
    }

    /**
     * Display the booking add-ons for edit
     * @param  int $book_id Booking id
     * @return Response
     */
    public function addons($book_id)
    {
        $booking = $this->repo_book->findById($book_id);

        $this->page_title = trans('booking.addons', ['id' => $booking->display_id]);

        $agents = $this->agents('suppliers');

        $this->vdata(compact('booking', 'book_id', 'agents'));

        return view('booking.addons', $this->vdata);
    }

    /**
     * Create bill for new booking
     * @param  array $input - User input data
     * @param  App\Booking $new_booking
     * @return int - New bill id
     */
    private function createBill($input, $new_booking)
    {
        if (empty($input['bil_id'])) {
            $accounting = $new_booking->resource->resourceType->accounting;

            $new_bill = (new BillRepository)->store([
                'bil_customer' => array_get($input, 'book_customer'),
                'bil_customer_name' => array_get($input, 'bil_customer_name'),
                'bil_booking' => $new_booking->book_id,
                'bil_accounting' => $accounting->acc_id,
                'bil_description' => $accounting->acc_bill_description,
                // 'bil_date' => date('Y-m-d'),
                // 'bil_due_date' => date('Y-m-d'),
                'bil_date' => Carbon::parse($new_booking->book_from)->format('Y-m-d'),
                'bil_due_date' => Carbon::parse($new_booking->book_from)->format('Y-m-d'),
            ]);

            $bili_bill = $new_bill->bil_id;
        } else {
            $bili_bill = $input['bil_id'];
        }

        return $bili_bill;
    }

    /**
     * Create bill items
     * @param  array $input - User input data
     * @param  int $bili_bill - Bill id
     * @return void
     */
    private function createBillItems($input, $bili_bill, $new_booking)
    {
        foreach ($input['rate'] as $key => $value) {
            (new BillItemRepository)->store([
                'bili_resource' => $input['resource'][$key],
                'bili_description' => $input['name'][$key],
                'bili_bill' => $bili_bill,
                'bili_unit_price' => $value,
                'bili_unit' => $input['unit'][$key],
                'bili_date' => $new_booking->book_from,
                'bili_with_tax' => in_array($new_booking->book_source, explode(',', env('SOURCES_WITHOUT_VAT'))) ? 0 : 1,
                // 'bili_gross' => $gross,
                // 'bili_tax' => calcTax($gross),
            ]);
        }
    }

    /**
     * Create bill items
     * @param  array $input - User input data
     * @param  int $booking - Booking object
     * @return void
     */
    private function createExtras($input, $booking, $bil_id)
    {
        foreach (array_get($input, 'extra_rate', []) as $key => $value) {
            $bili_item = (new BillItemRepository)->store([
                'bili_resource' => $input['extra'][$key],
                'bili_description' => $input['extra_name'][$key],
                'bili_bill' => $bil_id,
                'bili_unit_price' => $value,
                'bili_unit' => $input['extra_unit'][$key],
                'bili_date' => $booking->book_from,
                'bili_with_tax' => in_array($booking->book_source, explode(',', env('SOURCES_WITHOUT_VAT'))) ? 0 : 1,
            ]);

            $booking->addons()->create([
                'add_resource' => $input['extra'][$key],
                'add_bill_item' => $bili_item->bili_id,
                'add_customer' => $booking->book_customer,
                'add_customer_name' => $booking->customer->full_name,
                'add_date' => date('Ymd'),
                'add_pax' => $input['extra_unit'][$key],
            ]);
        }
    }

    /**
     * Return agents list
     * @return array
     */
    private function agents($type)
    {
        return (new AgentRepository)->ofType($type)->getDropDown('ag_id', 'ag_name');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BookingRepository;
use Repositories\ResourceRepository;
// use Repositories\CountryRepository;
use Repositories\BillRepository;
use Repositories\AddonRepository;
use Repositories\BillItemRepository;
use App\BookingFilter;
use App\Booking;
use App\Customer;
use DB;

class BookingController extends MainController
{
  protected $repo_book;

  public function __construct(BookingRepository $repo_book)
  {
    parent::__construct();

    $this->repo_book = $repo_book;

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    // $countries = (new CountryRepository)->getDropDown();
    //
    // $this->vdata(compact('countries'));
  }

  public function index(Request $request)
  {
    $filters = new BookingFilter($request->input());

    $filter = $request->input();

    $this->page_title = trans('booking.list');

    $list = $this->repo_book->getPages($filters, [['table' => 'customers', 'left_col' => 'cus_id', 'right_col' => 'book_customer']]);

    $this->vdata(compact('list', 'filter'));

    return view('booking.list', $this->vdata);
  }

  public function create(Request $request, Customer $customer)
  {
    $input = $request->input();

    $this->selectedSlot($input);
    // $resource = (new ResourceRepository)->find(array_get($input, 'resource'));
    //
    // $start = array_get($input, 'start');
    //
    // $end = array_get($input, 'start');

    $this->layout = 'layouts.modal';

    $this->page_title = trans('booking.new');

    $this->vdata(compact('customer'));

    return view('booking.new_basic', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    // $this->validation($request);
    DB::transaction(function() use($input) {

      $new_booking = $this->repo_book->store($input);

      if (empty($input['bil_id'])) {

        $accounting = $new_booking->resource->resourceType->accounting;

        $new_bill = (new BillRepository)->store([
          'bil_customer' => array_get($input, 'book_customer'),
          'bil_booking' => $new_booking->book_id,
          'bil_accounting' => $accounting->acc_id,
          'bil_description' => $accounting->acc_bill_description,
          'bil_date' => date('Y-m-d'),
          'bil_due_date' => date('Y-m-d'),
        ]);

        $bili_bill = $new_bill->bil_id;
      } else {

        $bili_bill = $input['bil_id'];
      }

      foreach ($input['rate'] as $key => $value) {

        $gross = $value * $input['unit'][$key];

        $resource = (new ResourceRepository)->findById($input['resource'][$key]);

        (new BillItemRepository)->store([
          'bili_resource' => $resource->rs_id,
          'bili_description' => $input['name'][$key],
          'bili_bill' => $bili_bill,
          'bili_unit_price' => $value,
          'bili_unit' => $input['unit'][$key],
          'bili_gross' => $gross,
          'bili_tax' => $this->calcTax($gross),
        ]);
      }
    });

    // $this->repo_book->store($request);

    return $this->goodReponse();
  }

  public function pick(Request $request)
  {
    $this->layout = 'layouts.modal';

    $this->page_title = trans('customer.new');

    return view('customer.new_basic', $this->vdata);
  }

  public function view(Booking $booking)
  {
    $this->layout = 'layouts.modal';

    $this->page_title = trans('booking.view', ['id' => $booking->book_id]);

    $booking = $this->repo_book->single($booking->book_id);

    $bills = $booking->bills;

    $customer = $booking->customer;

    $this->vdata(compact('booking', 'bills', 'customer'));

    return view('booking.view', $this->vdata);
  }

  public function action(Booking $booking)
  {

    $this->layout = 'layouts.modal';

    $this->page_title = trans('booking.action', ['id' => $booking->book_id]);

    $booking = $this->repo_book->single($booking->book_id);

    $bills = $booking->bills;

    $addons = $booking->addons;

    $this->vdata(compact('booking', 'bills', 'addons'));

    return view('booking.action', $this->vdata);
  }

  public function bills(Booking $booking)
  {
    $this->layout = 'layouts.modal';

    $this->page_title = trans('booking.action', ['id' => $booking->book_id]);

    $bills = $booking->bills;

    $this->vdata(compact('booking', 'bills'));

    return view('booking.bills', $this->vdata);
  }

  // protected function validation($request)
  // {
  //   $this->validate($request, [
  //       'book_resource' => 'required|exists:resources,rs_id',
  //       'book_customer' => 'required|exists:customers,cus_id',
  //       'book_from' => 'required|date',
  //       'book_to' => 'required|date',
  //       'book_pax' => 'required|numeric|min:1|max:20',
  //   ]);
  // }

  protected function selectedSlot($input)
  {
    if (array_get($input, 'resource')) {
      session(['booking.resource' => (new ResourceRepository)->findById(array_get($input, 'resource'))]);
    }

    if (array_get($input, 'start')) {
      session(['booking.start' => array_get($input, 'start')]);
    }

    if (array_get($input, 'end')) {
      session(['booking.end' => array_get($input, 'end')]);
    }
  }

  protected function calcTax($gross)
  {
    return $gross * config('myapp.tax_percent')/100;
  }

  public function checkin(Request $request, Booking $booking)
  {
    $booking->update(['book_status' => 'checkedin']);

    return $this->goodReponse();
  }

  public function checkout(Request $request, Booking $booking)
  {
    $booking->update(['book_status' => 'checkedout']);

    return $this->goodReponse();
  }

}

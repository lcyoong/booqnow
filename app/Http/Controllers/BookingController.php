<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Repositories\BookingRepository;
use Repositories\ResourceRepository;
use Repositories\BillRepository;
use Repositories\AddonRepository;
use Repositories\CustomerRepository;
use Repositories\BillItemRepository;
use Filters\BookingFilter;
use DB;

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

    $list = $this->repo_book->getPages($filters);

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

    $customer = !is_null($cus_id) ? (new CustomerRepository)->findById($cus_id) : null;

    $input = $request->input();

    $this->selectedSlot($input);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('booking.new');

    $this->vdata(compact('customer'));

    return view('booking.new_basic', $this->vdata);
  }

  /**
   * Process storing of new booking
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $input = $request->input();

    DB::transaction(function() use($input) {

      $new_booking = $this->repo_book->store($input);

      $bili_bill = $this->createBill($input, $new_booking);

      $this->createBillItems($input, $bili_bill);

    });

    return $this->goodReponse();
  }

  /**
   * Display the customer-selection form
   * @param  Request $request
   * @return Response
   */
  // public function pick(Request $request)
  // {
  //   $this->layout = 'layouts.modal';
  //
  //   $this->page_title = trans('customer.new');
  //
  //   return view('customer.new_basic', $this->vdata);
  // }

  /**
   * Display the booking 'action' pop-up form
   * @param  int $book_id Booking id
   * @return Response
   */
  public function action($book_id)
  {
    $booking = $this->repo_book->findById($book_id);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('booking.action', ['id' => $booking->book_id]);

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

    return $this->goodReponse();
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

    return $this->goodReponse();
  }

  // Create bill for new booking
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

    return $bili_bill;
  }

  /**
   * Create bill items
   * @param  array $input - User input data
   * @param  int $bili_bill - Bill id
   * @return void
   */
  private function createBillItems($input, $bili_bill)
  {
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
        'bili_tax' => calcTax($gross),
      ]);
    }

  }

}

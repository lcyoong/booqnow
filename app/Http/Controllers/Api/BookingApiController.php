<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\BookingRepository;
use Filters\BookingFilter;
use Carbon\Carbon;

class BookingApiController extends ApiController
{
  protected $repo_book;

  public function __construct(BookingRepository $repo_book)
  {
    $this->repo_book = $repo_book;
  }

  /**
   * Get active bookings for given parameters
   * @param  Request $request
   * @return array
   */
  public function active(Request $request)
  {
    $input = $request->input();

    $filters = new BookingFilter($request->input());

    // $filters = new BookingFilter(['start' => array($input, 'start'), 'end' => array($input, 'end')]);

    $list = (new BookingRepository)->get($filters);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = [
        'type' => 'booking',
        'id' => $item->book_id,
        'title' => $item->customer->full_name,
        'start' => Carbon::parse($item->book_from)->format('Y-m-d'),
        'end' => Carbon::parse($item->book_to)->format('Y-m-d'),
        'resourceId' => $item->book_resource,
        'special' => $item->book_special,
        'status' => $item->book_status,
        'backgroundColor' => config('myapp.bg-source-' . $item->book_source),
        'textColor' => '#999999',
        'borderColor' => '#999999',
      ];
    }

    return $return;
  }

  /**
   * Get active bookings for given parameters
   * @param  Request $request
   * @return array
   */
  public function get(Request $request)
  {
    $input = $request->input();

    $filters = new BookingFilter($request->input());

    return $this->repo_book->with(['customer', 'bills'])->getPages($filters);
  }

  /**
   * Get addons for a booking
   * @param  Request $request
   * @return array
   */
  public function addons(Request $request, $id)
  {
    $booking = (new BookingRepository)->findById($id);

    return $booking->addons()->with(['resource', 'bill_item'])->get();
  }

}

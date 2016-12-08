<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

use Repositories\BookingRepository;
use Filters\BookingFilter;

class BookingApiController extends ApiController
{
  public function active(Request $request)
  {
    $input = $request->input();

    $rs = new BookingRepository;

    $filters = new BookingFilter(['start' => array($input, 'start'), 'end' => array($input, 'end')]);

    $list = $rs->get($filters);

    $return = [];

    foreach ($list as $item)
    {
      $return[] = [
        'type' => 'booking',
        'id' => $item->book_id,
        'title' => $item->customer->full_name,
        'start' => $item->book_from,
        'end' => $item->book_to,
        'resourceId' => $item->book_resource,
        'status' => $item->book_status,
        'backgroundColor' => config('myapp.bg-source-' . $item->book_source),
        'textColor' => '#999999',
        'borderColor' => '#999999',
        // 'borderColor' => config('myapp.bd-source-' . $item->book_source),
      ];
    }

    // dd($list);

    return $return;

  }
}

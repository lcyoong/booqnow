<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Repositories\CountryRepository;
use Repositories\CodeRepository;
use Repositories\ResourceTypeRepository;
use Repositories\BookingSourceRepository;
use App\Http\Requests;
// use App\Merchant;
use Cache;

class MainController extends Controller
{
  protected $vdata = [];
  private $page_title;
  private $tenant;
  private $left_section_col;
  private $layout;
  private $new_path;
  private $filter;

  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->middleware('auth');

    $this->middleware('connect.tenant');

    $pay_methods = (new CodeRepository)->getDropDown('pay_method');

    $book_status = (new CodeRepository)->getDropDown('book_status', true);

    $cus_status = (new CodeRepository)->getDropDown('cus_status', true);

    $rs_status = (new CodeRepository)->getDropDown('rs_status', true);

    $countries = (new CountryRepository)->getDropDown();

    $resource_types = (new ResourceTypeRepository)->get();

    $booking_sources = (new BookingSourceRepository)->getDropDown('bs_id', 'bs_description');

    $left_section_col = 12;

    $tenant = false;

    $layout = 'layouts.tenant';

    $this->vdata = compact('left_section_col', 'tenant', 'layout', 'pay_methods', 'book_status', 'countries', 'resource_types', 'booking_sources', 'cus_status', 'rs_status');

    // $this->vdata = [
    //   'left_section_col' => 12,
    //   'tenant' => false,
    //   'layout' => 'layouts.tenant',
    //   'pay_methods' => $pay_methods,
    //   'book_status' => $book_status,
    //   'countries' => $countries,
    //   'resource_types' => $resource_types,
    //   'booking_sources' => $booking_sources,
    // ];
  }

  /**
   * Merge view data of child class with those from base class
   * @param  array $data
   * @return void
   */
  public function vdata($data)
  {
    $this->vdata = $data + $this->vdata;
  }

  /**
   * Set a property as view data
   * @param string $property
   * @param string $value
   */
  public function __set($property, $value)
	{
		if (property_exists($this, $property)) {
			$this->vdata[$property] = $value;
		}
	}

  /**
   * Format a default good response
   * @param  string $message
   * @param  array $data
   * @return Response
   */
  public function goodReponse($message = '', $data = null)
  {
    return response([
      'success' => true,
      'data' => $data,
      'message' => $message ? $message : trans('message.process_successful')
    ]);
  }
}

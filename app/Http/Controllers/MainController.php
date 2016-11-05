<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Repositories\CountryRepository;
use Repositories\CodeRepository;
use Repositories\ResourceTypeRepository;
use App\Http\Requests;
use App\Merchant;
use Cache;

class MainController extends Controller
{
  protected $vdata = [];
  private $page_title;
  private $tenant;
  private $left_section_col;
  private $layout;
  private $new_path;

  public function __construct()
  {
    $this->middleware('auth');

    $this->middleware('connect.tenant');

    $pay_methods = (new CodeRepository)->getDropDown('pay_method');

    $book_status = (new CodeRepository)->getDropDown('book_status', true);

    $countries = (new CountryRepository)->getDropDown();

    // $countries = (new ResourceTypeRepository)->getDropDown();

    $this->vdata = [
      'left_section_col' => 12,
      'tenant' => false,
      'layout' => 'layouts.tenant',
      'pay_methods' => $pay_methods,
      'book_status' => $book_status,
      'countries' => $countries,
    ];
  }

  public function vdata($data)
  {
    $this->vdata = $data + $this->vdata;
  }

  public function __set($property, $value)
	{
		if (property_exists($this, $property)) {
			$this->vdata[$property] = $value;
		}
	}

  public function goodReponse($message = '')
  {
    return response([
      'success' => true,
      'message' => $message ? $message : trans('message.process_successful')
    ]);
  }
}

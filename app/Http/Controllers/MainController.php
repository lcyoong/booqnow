<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    $this->vdata = [
      'left_section_col' => 12,
      'tenant' => false,
      'layout' => 'layouts.tenant',
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

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
  private $left_section_col;

  public function __construct()
  {
    $this->middleware('auth');

    $this->middleware('connect.tenant');

    $this->vdata = [
      'left_section_col' => 12
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


}

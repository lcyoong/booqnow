<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;

class PosController extends MainController
{
    public function __construct()
    {
        parent::__construct();

        $this->tenant = true;

        $this->layout = 'layouts.pos';
    }

    public function index()
    {
        return view('pos.index', $this->vdata);
    }

    public function create()
    {
        $bookings = Booking::where('book_status', 'checkedin')->toDropDown('book_id', 'book_pos');

        $this->vdata(compact('bookings'));

        return view('pos.new', $this->vdata);
    }

    public function kitchen()
    {
        return view('pos.kitchen', $this->vdata);
    }

    public function order()
    {
        return view('pos.order', $this->vdata);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Reports\ProfitLoss;

class ReportController extends MainController
{
  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  public function profitLoss(Request $request)
  {
    $report = new ProfitLoss;

    $report->handle($request);

    $report->output();
  }

  public function occupancy(Occupancy $report, Request $request)
  {
    $report->handle($request);
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Contracts\ReportLogInterface;
use App\Http\Requests;
use Reports\ProfitLossExcel;

class ReportController extends MainController
{
  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;

    $this->layout = 'layouts.tenant';
  }

  public function profitLossFilter(Request $request)
  {
    $this->filter = $request->input();

    return view('report.pnl', $this->vdata);
  }

  /**
   * Generate Profit Loss report
   * @param  Request $request
   * @return Response
   */
  public function profitLoss(Request $request)
  {
    $report = new ProfitLossExcel('pnl');

    $report->setYear($request->input('year'));

    $report->handle();

    return $this->goodReponse();
  }

  public function occupancy(Occupancy $report, Request $request)
  {
    $report->handle($request);
  }

}

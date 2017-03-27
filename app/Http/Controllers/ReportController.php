<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Contracts\ReportLogInterface;
use App\Http\Requests;
use Reports\ProfitLossExcel;
use Repositories\ReportRepository;
// use App\Events\ReportRequested;
use App\Jobs\ProcessReport;
use Storage;

class ReportController extends MainController
{
  protected $repo;

  public function __construct(ReportRepository $repo)
  {
    parent::__construct();

    $this->tenant = true;

    $this->repo = $repo;
  }

  public function profitLoss(Request $request)
  {
    $this->filter = $request->input();

    $this->page_title = trans('report.pnl_title');

    $list = $this->repo->ofType('ProfitLossExcel')->getPages();

    $this->vdata(compact('list'));

    return view('report.pnl', $this->vdata);
  }

  public function monthlyOccupancy(Request $request)
  {
    $this->page_title = trans('report.monthly_occupancy_title');

    $list = $this->repo->ofType('MonthlyOccupancy')->getPages();

    $this->vdata(compact('list'));

    return view('report.monthly_occupancy', $this->vdata);
  }

  public function request(Request $request)
  {
    $input = $request->input();

    $input['rep_filter'] = serialize($input['rep_filter']);

    $report = $this->repo->store($input);

    if ($report->rep_id) {
      dispatch(new ProcessReport($report));
		}

    return $this->goodReponse();
  }

  public function download($report_id)
  {
    $report = $this->repo->findById($report_id);

    $file_path = "reports/" . $report->rep_output_path;

    if (Storage::exists($file_path)) {

      return response()->download(storage_path("app/" . $file_path));

    }
  }
}

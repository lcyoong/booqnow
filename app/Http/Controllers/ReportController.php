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

    /**
     * P&L report display form
     * @param  Request $request
     * @return Response
     */
    public function profitLoss(Request $request)
    {
        $this->filter = $request->input();

        $this->page_title = trans('report.pnl_title');

        $list = $this->repo->ofType('pnl')->getPages();

        $this->vdata(compact('list'));

        return view('report.pnl', $this->vdata);
    }

    /**
     * Occupancy (by room) display form
     * @param  Request $request
     * @return Response
     */
    public function occupancyByRoom(Request $request)
    {
        $this->page_title = trans('report.monthly_occupancy_title');

        $list = $this->repo->ofType('occupancy_by_room')->getPages();

        $this->vdata(compact('list'));

        return view('report.occupancy_by_room', $this->vdata);
    }

    /**
     * Occupancy (by day of month) display form
     * @param  Request $request
     * @return Response
     */
    public function occupancyByDay(Request $request)
    {
        $this->page_title = trans('report.daily_occupancy_title');

        $list = $this->repo->ofType('occupancy_by_day')->getPages();

        $this->vdata(compact('list'));

        return view('report.occupancy_by_day', $this->vdata);
    }

    /**
     * Occupancy (by national) display form
     * @param  Request $request
     * @return Response
     */
    public function occupancyByNational(Request $request)
    {
        $type = 'occupancy_by_national';

        $this->page_title = trans('report.national_occupancy_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.occupancy_by_national', $this->vdata);
    }

    /**
     * Occupancy (by source) display form
     * @param  Request $request
     * @return Response
     */
    public function occupancyBySource(Request $request)
    {
        $this->page_title = trans('report.source_occupancy_title');

        $list = $this->repo->ofType('occupancy_by_source')->getPages();

        $this->vdata(compact('list'));

        return view('report.occupancy_by_source', $this->vdata);
    }

    /**
     * Monthly stat display form
     * @param  Request $request
     * @return Response
     */
    public function monthlyStat(Request $request)
    {
        $type = 'monthly_stat';

        $this->page_title = trans('report.monthly_stat_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.monthly_stat', $this->vdata);
    }

    /**
     * Daily tour display form
     * @param  Request $request
     * @return Response
     */
    public function dailyTour(Request $request)
    {
        $type = 'daily_tour';

        $this->page_title = trans('report.daily_tour_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.daily_tour', $this->vdata);
    }

    /**
     * Daily transfer display form
     * @param  Request $request
     * @return Response
     */
    public function dailyTransfer(Request $request)
    {
        $type = 'daily_transfer';

        $this->page_title = trans('report.daily_transfer_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.daily_transfer', $this->vdata);
    }

    /**
     * Monthly deposit display form
     * @param  Request $request
     * @return Response
     */
    public function monthlyDeposit(Request $request)
    {
        $type = 'monthly_deposit';

        $this->page_title = trans('report.monthly_deposit_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.monthly_deposit', $this->vdata);
    }

    /**
     * Monthly deposit display form
     * @param  Request $request
     * @return Response
     */
    public function monthlyDepositByFuture(Request $request)
    {
        $type = 'monthly_deposit_future';

        $this->page_title = trans('report.monthly_deposit_by_future_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.monthly_deposit_future', $this->vdata);
    }

    /**
     * Monthly future revenue display form
     * @param  Request $request
     * @return Response
     */
    public function monthlyRevenueByFuture(Request $request)
    {
        $type = 'monthly_revenue_future';

        $this->page_title = trans('report.monthly_revenue_by_future_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.monthly_revenue_future', $this->vdata);
    }

    /**
     * Monthly deposit display form
     * @param  Request $request
     * @return Response
     */
    public function monthlyUnitsSold(Request $request)
    {
        $type = 'monthly_units_sold';

        $this->page_title = trans('report.monthly_units_sold_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.monthly_units_sold', $this->vdata);
    }

    /**
     * Export bills display form
     * @param  Request $request
     * @return Response
     */
    public function exportBills(Request $request)
    {
        $type = 'export_bills';

        $this->filter = $request->input();

        $this->page_title = trans('report.export_bills_title');

        $list = $this->repo->ofType('export_bills')->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.export_bills', $this->vdata);
    }

    /**
     * Export receipts display form
     * @param  Request $request
     * @return Response
     */
    public function exportReceipts(Request $request)
    {
        $type = 'export_receipts';

        $this->filter = $request->input();

        $this->page_title = trans('report.export_receipts_title');

        $list = $this->repo->ofType('export_receipts')->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.export_receipts', $this->vdata);
    }

    /**
     * Cash received display form
     * @param  Request $request
     * @return Response
     */
    public function cashReceived(Request $request)
    {
        $type = 'cash_received';

        $this->filter = $request->input();

        $this->page_title = trans('report.cash_received_title');

        $list = $this->repo->ofType($type)->getPages();

        $this->vdata(compact('list', 'type'));

        return view('report.cash_received', $this->vdata);
    }

    /**
     * Report request submission
     * @param  Request $request
     * @return Response
     */
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

    /**
     * Report download
     * @param  Request $request
     * @return Response
     */
    public function download($report_id)
    {
        $report = $this->repo->findById($report_id);

        $file_path = "reports/" . $report->rep_output_path;

        if (Storage::exists($file_path)) {
            return response()->download(storage_path("app/" . $file_path));
        }
    }
}

<?php

namespace Reports;

use Illuminate\Http\Request;
use Reports\BaseReport;
use App\Traits\ReportTrait;
use Repositories\BillRepository;
use App\BillItem;
use App\Bill;
use App\ResourceType;

class ProfitLoss extends BaseReport
{
  // use ReportTrait;

  public function handle(Request $request)
  {
    $input = $request->input();

    $bill = new Bill;

    $resources = (new ResourceType)->get();

    foreach($resources as $resource)
    {
      $this->data[] = [$resource->rty_name];
    }

    // dd($data);
    //
    // $data = $bill->selectRaw('rs_type, month(bil_date), sum(bili_gross)')->join('bill_items', 'bili_bill', '=', 'bil_id')->join('resources', 'rs_id', '=', 'bili_resource')->groupBy('rs_type', 'month(bil_date)')->get();
  }

  public function selection()
  {
    echo 'selection pnl';
  }
}

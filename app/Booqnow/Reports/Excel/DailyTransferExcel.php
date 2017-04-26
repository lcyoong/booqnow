<?php

namespace Reports;

use App\Events\ReportCreated;

class DailyTransferExcel extends DailyAddonExcel
{
  public function __construct($report)
  {
    parent::__construct($report, 4, trans('report.daily_transfer_title'));
  }
}

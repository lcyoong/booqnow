<?php

namespace Reports;

use App\Events\ReportCreated;

class DailyTourExcel extends DailyAddonExcel
{
  public function __construct($report)
  {
    parent::__construct($report, 2, trans('report.daily_tour_title'));
  }
}

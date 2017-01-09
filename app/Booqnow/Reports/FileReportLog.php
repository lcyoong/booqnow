<?php

namespace Reports;

use Contracts\ReportLogInterface;

class FileReportLog implements ReportLogInterface
{
  public function write($data)
  {
    $f = fopen(storage_path('app/reports/log.txt'), 'a');

    fwrite($f, PHP_EOL . $data);

    fclose($f);
  }

  public function read()
  {

  }
}

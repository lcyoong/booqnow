<?php

namespace Reports;

use Illuminate\Http\Request;

// use App\Contracts\ReportContract;
use App\Traits\ReportTrait;

abstract class BaseReport
{
  protected $data;
  // use ReportTrait;

  abstract public function handle(Request $request);

  abstract public function selection();

  public function output()
  {
    dd($this->data);
  }

  public function log()
  {
    echo 'log';
  }

  // public function process()
  // {
  //   $this->handle();
  //
  //   $this->output();
  //
  //   $this->log();
  // }
}

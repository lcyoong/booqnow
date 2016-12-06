<?php

namespace App\Contracts;

interface ReportContract
{
  public function selection();

  public function handle();
}

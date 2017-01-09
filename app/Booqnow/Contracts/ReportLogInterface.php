<?php

namespace Contracts;

interface ReportLogInterface
{
  public function write($data);

  public function read();
}

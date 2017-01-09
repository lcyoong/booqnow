<?php

namespace App\Traits;

use Contracts\ReportLogInterface;
use App;
use Storage;

trait ReportTrait
{
  protected $reportname;

  protected $log;

  /**
   * Log the report generation
   * @param  string $value    Additional value to append to log
   * @return void
   */
  public function log($value)
  {
    $this->log = app('Contracts\ReportLogInterface');

    $this->log->write($this->reportname . $value);
  }

  /**
   * Get the report output
   * @return mixed
   */
  public function get()
  {
    $file_path = $this->path();

    if (Storage::exists($file_path)) {

      return Storage::get($file_path);

    }
  }

  /**
   * Get the relative path of the report file
   * @return string
   */
  public function path()
  {
    return sprintf('reports/%s.%s', $this->reportname, $this->ext);
  }

}

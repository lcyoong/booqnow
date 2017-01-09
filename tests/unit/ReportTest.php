<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Reports\ProfitLossExcel;
use Reports\BillExportExcel;

class ReportTest extends TestCase
{
  protected $report;
  // /**
  //  * @test
  //  *
  //  * @return void
  //  */
  // public function excel_report_data()
  // {
  //   $this->report = new ExcelReport();
  //
  //   $this->report->setData(['Hello']);
  //
  //   $this->assertEquals($this->report->getData(), ['Hello']);
  // }

  /**
   * @test
   *
   * @return void
   */
  public function excel_report_handling()
  {
    $this->report = new ProfitLossExcel('pnl');

    $this->report->handle();

    $output = $this->report->get();

    $this->assertTrue(!is_null($output));

    $this->report = new BillExportExcel('bill');

    $this->report->handle();

    $output = $this->report->get();

    $this->assertTrue(!is_null($output));
  }

  /**
   * @test
   *
   * @return void
   */
  public function excel_report_logging()
  {
    $this->report = new ProfitLossExcel('pnl');

    $this->report->handle();

    $this->report->log('Handled');
  }


  // /**
  //  * @test
  //  * A basic test example.
  //  *
  //  * @return void
  //  */
  // public function report_profit_loss()
  // {
  //   $pl = new ProfitLoss(Carbon::now()->year);
  //
  //   $this->report = new Report($pl->data());
  //
  //   $this->assertEquals($this->report->output(), ['Hello']);
  // }

}

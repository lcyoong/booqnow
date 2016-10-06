<?php

namespace App\Listeners;

use App\Events\MerchantCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Booqlee\Tenant;
use Artisan;
use DB;

class CreateAndMigrateDatabase
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MerchantCreated  $event
     * @return void
     */
    public function handle(MerchantCreated $event)
    {
      $database = $event->merchant->mer_connection;

      DB::statement("CREATE DATABASE $database");

      Tenant::connect(['database' => $database]);

      Artisan::call('migrate', array('--database' => $database, '--path' => '/database/migrations/tenant'));
    }
}

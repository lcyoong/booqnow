<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Booqlee\Tenant;
use Artisan;

class NewSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New subscription setup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $database = 'Test9399';
      // Create new database
      DB::statement("CREATE DATABASE $database");

      Tenant::connect(['database' => $database]);

      // Migrate to new database
      Artisan::call('migrate', array('--database' => $database));
    }
}

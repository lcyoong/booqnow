<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Validator::extend( 'composite_unique', function ( $attribute, $value, $parameters, $validator ) {

          // remove first parameter and assume it is the table name
          $table = array_shift( $parameters );

          // start building the conditions
          $fields = [ $attribute => $value ]; // current field, company_code in your case

          // iterates over the other parameters and build the conditions for all the required fields
          while ( $field = array_shift( $parameters ) ) {
              // $fields[ $field ] = $this->getValue( $field );
              $fields[ $field ] = array_get($validator->getData(), $field);
          }

          // query the table with all the conditions
          $result = \DB::table( $table )->select( \DB::raw( 1 ) )->where( $fields )->first();

          return empty( $result ); // edited here
      });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Contracts\BaseRepositoryInterface', 'Repositories\EloquentRepository');
        $this->app->bind('Contracts\ReportLogInterface', 'Reports\FileReportLog');
        $this->app->bind('Contracts\ReportInterface', 'Reports\ExcelReport');
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // config(['app.timezone' => 'Asia/Kuala_Lumpur']);

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

      Validator::extend( 'unique_but_self', function ( $attribute, $value, $parameters, $validator ) {

          // remove first parameter and assume it is the table name
          $table = array_shift( $parameters );

          $unique_field = array_shift( $parameters );

          $unique_value = !is_null($unique_field) ? array_get($validator->getData(), $unique_field, '') : '';

          $self_field = array_shift( $parameters );

          $self_id = !is_null($self_field) ? array_get($validator->getData(), $self_field, 0) : 0;

          // query the table with all the conditions
          $result = \DB::table( $table )->select( \DB::raw( 1 ) )->where($unique_field, '=', $unique_value)->where($self_field, '!=', $self_id)->first();

          return empty( $result ); // edited here
      });

      /**
       * Check if the attempt overlap an existing booking
       * $attribute       The field to be validated
       * $value           The value of $attribute
       * $parameters      Additional parameters
       * @var string
       */
      Validator::extend( 'overlap_booking', function ( $attribute, $value, $parameters, $validator ) {

        $table = "bookings";

        $from = array_get($validator->getData(), array_shift( $parameters ));

        $to = array_get($validator->getData(), array_shift( $parameters ));

        $parm_id = array_shift( $parameters );

        $id = !is_null($parm_id) ? array_get($validator->getData(), $parm_id, 0) : 0;

        $query = \DB::table( $table )->select( \DB::raw( 1 ) )
              ->where( 'book_resource', '=', $value )
              ->where( 'book_status', '!=', 'cancelled' )
              ->whereDate('book_to', '>', Carbon::parse($from)->format('Y-m-d'))
              ->whereDate('book_from', '<', Carbon::parse($to)->format('Y-m-d'));

        if ($id > 0) {
          $query->where('book_id', '!=', $id);
        }

        $result = $query->first();

        return empty( $result );

      });

      /**
       * Check if the attempt overlap an existing maintenance
       * $attribute       The field to be validated
       * $value           The value of $attribute
       * $parameters      Additional parameters
       * @var string
       */
      Validator::extend( 'overlap_maintenance', function ( $attribute, $value, $parameters, $validator ) {

          $table = "resource_maintenances";

          $from = array_get($validator->getData(), array_shift( $parameters ));
          $to = array_get($validator->getData(), array_shift( $parameters ));

          $result = \DB::table( $table )->select( \DB::raw( 1 ) )->where( 'rm_resource', '=', $value )->whereDate('rm_to', '>', Carbon::parse($from)->format('Y-m-d'))->whereDate('rm_from', '<', Carbon::parse($to)->format('Y-m-d'))->where('rm_status', '=', 'active')->first();

          return empty( $result );

      });

      Blade::directive('permitted', function ($expression) {
          return "<?php if (Auth::user()->can($expression) || Auth::user()->hasRole('super_admin')): ?>";
      });


      Blade::directive('endpermitted', function ($expression) {
          return "<?php endif; ?>";
      });

      Relation::morphMap([
        'customers' => 'App\Customer',
        'bills' => 'App\Bill',
        'bill_items' => 'App\BillItem',
        'receipts' => 'App\Receipt',
        'bookings' => 'App\Booking',
        'addons' => 'App\Addon',
        'expenses_category' => 'App\ExpenseCategory',
        'expenses' => 'App\Expense',
        'agents' => 'App\Agent',
      ]);
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

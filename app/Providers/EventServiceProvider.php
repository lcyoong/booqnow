<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MerchantCreated' => [
          'App\Listeners\SubscribeMerchant',
          'App\Listeners\AddDefaultOwner',
          'App\Listeners\CreateAndMigrateDatabase',
        ],
        // 'App\Events\ReportCreated' => [
        //   'App\Listeners\LogReport',
        // ],
        'App\Events\ModelCreated' => [
          'App\Listeners\AuditLogCreated',
        ],
        'App\Events\ModelUpdated' => [
          'App\Listeners\AuditLogUpdated',
        ],
        // 'App\Events\ReportRequested' => [
        //   'App\Listeners\QueueReport',
        // ],
        'App\Events\ReportCompleted' => [
          'App\Listeners\UpdateReportCompleted',
          // 'App\Listeners\LogReport',
          // 'App\Listeners\SendNotification',
        ],
        'App\Events\ReportFailed' => [
          'App\Listeners\UpdateReportRetry',
          // 'App\Listeners\SendNotification',
        ],
        'App\Events\BookingCancelled' => [
          'App\Listeners\CancelBookingBills',
          'App\Listeners\CancelBookingAddOns',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

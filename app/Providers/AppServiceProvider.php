<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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

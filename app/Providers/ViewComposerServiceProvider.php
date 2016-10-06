<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Merchant;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer('partials.topbar', function($view)
      {
        if (auth()->check()) {
          $view->with('merchants', Merchant::mine()->get());
        }
      });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('bsHText', 'components.form.htext', ['name', 'label', 'value', 'col1', 'col2', 'attributes']);
        Form::component('bsHSelect', 'components.form.hselect', ['name', 'label', 'list', 'value', 'col1', 'col2', 'attributes']);
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

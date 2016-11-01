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
        Form::component('bsHText', 'components.form.htext', ['name', 'label', 'value' => null, 'col1' => 2, 'col2' => 4, 'attributes' => []]);
        Form::component('bsHEmail', 'components.form.hemail', ['name', 'label', 'value' => null, 'col1' => 2, 'col2' => 4, 'attributes' => []]);
        Form::component('bsHSelect', 'components.form.hselect', ['name', 'label', 'list', 'value' => null, 'col1' => 2, 'col2' => 4, 'attributes' => []]);
        Form::component('bsHTextarea', 'components.form.htextarea', ['name', 'label', 'value' => null, 'col1' => 2, 'col2' => 4, 'attributes' => []]);

        Form::component('bsText', 'components.form.text', ['name', 'label', 'value' => null, 'attributes' => [], 'col' => 3]);
        Form::component('bsDate', 'components.form.date', ['name', 'label', 'value' => null, 'attributes' => [], 'col' => 3]);
        Form::component('bsEmail', 'components.form.email', ['name', 'label', 'value' => null, 'attributes' => [], 'col' => 3]);
        Form::component('bsSelect', 'components.form.select', ['name', 'label', 'list', 'value' => null, 'attributes' => [], 'col' => 3]);
        Form::component('bsTextarea', 'components.form.textarea', ['name', 'label', 'value' => null, 'attributes' => [], 'col' => 3]);
        Form::component('bsNumber', 'components.form.number', ['name', 'label', 'value' => null, 'attributes' => [], 'col' => 3]);

        Form::component('filterText', 'components.form.filtertext', ['name', 'label', 'value' => null, 'attributes' => [], 'col' => 3]);
        Form::component('filterSelect', 'components.form.filterselect', ['name', 'label', 'list', 'value' => null, 'attributes' => [], 'col' => 3]);

        Form::component('showField', 'components.form.showfield', ['value', 'label', 'col' => 3]);
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

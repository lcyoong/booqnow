const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.copy(
        'node_modules/fullcalendar-scheduler/dist/scheduler.css',
        'resources/assets/css'
    );
    mix.copy(
        'node_modules/fullcalendar/dist/fullcalendar.css',
        'resources/assets/css'
    );
    mix.copy(
        'node_modules/font-awesome/fonts',
        'public/build/fonts'
    );
    // mix.copy(
    //     'node_modules/moment/min/moment.min.js',
    //     'public/js'
    // );
    mix.copy(
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
        'resources/assets/css'
    );
    mix.copy(
        'node_modules/select2/dist/css/select2.css',
        'resources/assets/css'
    );
    mix.copy(
        'node_modules/vue2-autocomplete-js/dist/style/vue2-autocomplete.css',
        'resources/assets/css'
    );
    // mix.copy(
    //     'node_modules/moment/locale',
    //     'resources/assets/js/moment/locale'
    // );

    mix.sass('app.scss');

    mix.styles([
      'public/css/app.css',
      'resources/assets/css/fullcalendar.css',
      'resources/assets/css/scheduler.css',
      'resources/assets/css/bootstrap-datepicker.css',
      'resources/assets/css/select2.css',
      'resources/assets/css/vue2-autocomplete.css',
      'node_modules/font-awesome/css/font-awesome.min.css'
    ], 'public/css/app.css', './');

    // mix.scripts(['moment/locales.min.js', 'moment/moment.min.js', 'app.js'], 'public/js/app.js');

    mix.version(['css/app.css', 'js/app.js'])
        // .webpack('moment.min.js')
       .webpack('app.js');
});

Elixir.webpack.mergeConfig({
});

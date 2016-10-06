const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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

    mix.sass('app.scss');

    mix.styles([
      'public/css/app.css',
      'resources/assets/css/fullcalendar.css',
      'resources/assets/css/scheduler.css',
      'node_modules/font-awesome/css/font-awesome.min.css'
    ], 'public/css/app.css', './');

    mix.version('css/app.css')
       .webpack('app.js');
});

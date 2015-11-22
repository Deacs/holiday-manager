var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 | and what?
 */

elixir(function(mix) {
    mix.scripts([
        'app/vendor/jquery.js',
        'app/vendor/modernizr.js',
        'app/foundation/foundation.js',
        'app/foundation/foundation.topbar.js',
        'app/foundation/foundation.alert.js',
        'app/foundation/foundation.reveal.js',
        'app/vendor/dropzone.js',
        'app/vendor/lity.js',
    ], 'public/js/vendor.js')
    .styles([
        'app/vendor/normalize.css',
        'app/vendor/dropzone.css',
        'app/vendor/lity.css',
        'app/vendor/foundation.css',
        'app/custom.css',
    ], './public/css/app.css'
    ),
    mix.browserify('app.js'),
    mix.phpUnit()
});

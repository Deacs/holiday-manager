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
        'app/foundation/foundation.reveal.js'
    ], 'public/js/vendor.js'),
    mix.browserify('app.js')
});

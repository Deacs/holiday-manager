var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.scripts([
        'app/vue.min.js',
        'app/vue-resource.min.js',
        'app/vendor/jquery.js',
        'app/foundation/foundation.js',
        'app/foundation/foundation.topbar.js',
        'app/foundation/foundation.alert.js',
        'app/foundation/foundation.reveal.js'
    ], 'public/js/vendor.js')
});

var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

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
        'app/vendor/sweetalert-dev.js',
    ], 'public/js/vendor.js')
    .styles([
        'app/vendor/normalize.css',
        'app/vendor/dropzone.css',
        'app/vendor/lity.css',
        'app/vendor/foundation.css',
        'app/vendor/sweetalert.css',
        'app/custom.css',
    ], './public/css/app.css'
    ),
    mix.browserify('app.js'),
    mix.phpUnit()
});

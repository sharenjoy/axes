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

    mix.sass(["app.scss"]);

    mix.styles([
        "resources/assets/vendor/bootstrap/dist/css/bootstrap.css",
        "resources/assets/vendor/fontawesome/css/font-awesome.css",
        "public/css/app.css"
    ], "public/css/all.css", "./");

    mix.version(["css/all.css"]);

});

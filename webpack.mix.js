let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'resources/assets/css');
mix.copy('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css', 'resources/assets/css');


mix.copy('node_modules/jquery/dist/jquery.min.js', 'resources/assets/js');
mix.copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'resources/assets/js');
mix.copy('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js', 'resources/assets/js');


mix.styles([
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/dataTables.bootstrap4.css'
    ], 'public/css/app.css');

mix.scripts([
        'resources/assets/js/app.js',
        'resources/assets/js/jquery.min.js',
        'resources/assets/js/bootstrap.bootstrap.bundle.min.js',
        'resources/assets/js/dataTables.bootstrap4.js'
    ], 'public/js/app.js');



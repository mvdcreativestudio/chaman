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


mix.setPublicPath('../public')
   .js('resources/assets/js/app.js', 'js')
   .sass('resources/assets/sass/app.scss', 'css');


mix.combine([
   '../template/thirdparty/bootstrap/js/popper.min.js',
], '../template/compiled/vendor.js');
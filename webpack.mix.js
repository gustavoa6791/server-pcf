const mix = require('laravel-mix');

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
mix.webpackConfig(require('./webpack.config'));

mix
  .react('resources/js/app.jsx', 'public/js')
  .react('resources/js/login.jsx', 'public/js')
  .sass('resources/sass/app.scss', 'public/css');
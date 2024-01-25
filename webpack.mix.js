const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.js('resources/js/app.js', 'public/js').vue()
 .postCss('resources/css/app.css', 'public/css', [
     require('postcss-import'),
     require('tailwindcss'),
 ])
 .webpackConfig(require('./webpack.config'));
mix.js('resources/js/essential.js', 'public/js').vue();
mix.js('resources/js/Company/details.js', 'public/js/Company').vue();
mix.js('resources/js/job.js', 'public/js').vue();
mix.js('resources/js/apply.js', 'public/js').vue();
mix.js('resources/js/faqs.js', 'public/js').vue();
mix.js('resources/js/homepage.js', 'public/js');
if (mix.inProduction()) {
 mix.version();
}
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const WebpackShellPlugin = require('webpack-shell-plugin');

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

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css')
   .options({
       extractVueStyles: true,
       globalVueStyles: 'resources/sass/main.scss',
       processCssUrls: false,
       postCss: [
           tailwindcss('./tailwind.config.js')
       ]
   });

mix.webpackConfig({
    plugins:
    [
        new WebpackShellPlugin({
            onBuildStart: ['php artisan lang:js resources/js/translations.js --no-lib'], onBuildEnd: []
        })
    ]
})


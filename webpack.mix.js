const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

var LiveReloadPlugin = require('webpack-livereload-plugin');

mix.webpackConfig({
    plugins: [new LiveReloadPlugin()]
});

var gulp = require('gulp');
const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

//elixir(mix => {
//    mix.sass('app.scss')
//       .webpack('app.js');
//});

elixir(function(mix){
    mix.copy('vendor/bower_dl/jquery/dist/jquery.js','resources/assets/js')
        .copy('vendor/bower_dl/bootstrap/dist/fonts/**','public/assets/fonts')
        .copy('vendor/bower_dl/bootstrap/dist/js/bootstrap.js','resources/assets/js')
        .copy('vendor/bower_dl/bootstrap/less/**','resources/assets/less/bootstrap')
        .copy('vendor/bower_dl/font-awesome/fonts/**','public/assets/fonts')
        .copy('vendor/bower_dl/font-awesome/less/**','resources/assets/less/fontAwesome')
        .copy('vendor/bower_dl/datatables/media/js/jquery.dataTables.js','resources/assets/js')
        .copy('vendor/bower_dl/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css','resources/assets/less/other/dataTables.bootstrap.less')
        .copy('vendor/bower_dl/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js','resources/assets/js')

    mix.less('resources/assets/less/admin.less','public/assets/css/admin.css');
    mix.scripts(
        ['jquery.js','bootstrap.js','jquery.dataTables.js','dataTables.bootstrap.js'],
        'public/assets/js/admin.js'
    );
});

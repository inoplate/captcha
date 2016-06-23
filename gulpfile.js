var gulp = require("gulp");
var elixir = require('laravel-elixir');
var shell = require('gulp-shell');
var task = elixir.Task;

elixir.extend('publishAssets', function() {
    new task('publishAssets', function() {
        return gulp.src("").pipe(shell("cd ../../../ && php artisan vendor:publish --provider=\"Inoplate\\Captcha\\CaptchaServiceProvider\" --tag=public --force"));
    }).watch("resources/assets/**");
});

elixir(function(mix) {
    mix.less('captcha.less')
       .coffee('captcha.coffee')
       .publishAssets();
});
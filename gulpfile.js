var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.less('captcha.less')
       .coffee('captcha.coffee');
});
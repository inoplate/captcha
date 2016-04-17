<?php

namespace Inoplate\Captcha;

use Validator;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Booting package
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadPublic();
        $this->loadView();
        $this->loadConfiguration();
        $this->loadRoutes($router);
        $this->loadTranslation();
        $this->registerValidator();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('captcha', function ($app) {
            return new Factory($app);
        });

        $this->app->singleton('captcha.default', function ($app) {
            return $app['captcha']->drive();
        });

        $this->app->alias('captcha.default', 'Inoplate\Captcha\Challenge');
    }

    /**
     * Load package routes
     * 
     * @return void
     */
    protected function loadRoutes(Router $router)
    {
        $router->group(['namespace' => 'Inoplate\Captcha\Http\Controllers', 'middleware' => ['web']], function ($router) {

            require __DIR__.'/Http/routes.php';

        });
    }

    /**
     * Load package's public assets
     * 
     * @return void
     */
    protected function loadPublic()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/inoplate-captcha'),
        ], 'public');
    }

    /**
     * Load package's views
     * 
     * @return void
     */
    protected function loadView()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'inoplate-captcha');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/inoplate-captcha'),
        ], 'views');
    }

    /**
     * Load package configuration
     * 
     * @return void
     */
    protected function loadConfiguration()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/captcha.php', 'inoplate.captcha'
        );

        $this->publishes([
            __DIR__.'/../config/captcha.php' => config_path('inoplate/captcha.php'),
        ], 'config');
    }

    /**
     * Load packages's translation
     * 
     * @return void
     */
    protected function loadTranslation()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'inoplate-captcha');
    }

    /**
     * Register package validator
     * 
     * @return void
     */
    protected function registerValidator()
    {
        Validator::extend('captcha', function($attribute, $value, $parameters, $validator) {
            return $this->app['captcha.default']->check($value);
        });
    }
}
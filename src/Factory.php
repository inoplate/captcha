<?php

namespace Inoplate\Captcha;

use InvalidArgumentException;
use Illuminate\Contracts\Foundation\Application;

class Factory
{
    /**
     * @var Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $drivers = [];

    /**
     * @var array
     */
    protected $customCreators = [];

    /**
     * Create new Factory instace
     * 
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get a Challange instance
     * 
     * @param  string $driver
     * @return Challange
     */
    public function drive($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if(isset($this->drivers[$driver])) {
            return $this->drivers[$driver];
        }else {
            return $this->drivers[$driver] = $this->resolve($driver);
        }
    }

    /**
     * Create ImagaChallenge
     * 
     * @param  array  $options
     * @return ImageChallenge
     */
    public function createImageChallenge(array $options)
    {
        return new ImageChallenge($options);
    }

    /**
     * Create Rechaptcha challenge
     * 
     * @param  array  $options
     * @return RecaptchaChallenge
     */
    public function createRecaptchaChallenge(array $options)
    {
        return new RecaptchaChallenge($this->app['request'], $options);
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param  string    $driver
     * @param  \Closure  $callback
     * @return $this
     */
    public function extend($driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }

    /**
     * Resolve driver
     * 
     * @param  string $drive
     * @return Challenge
     */
    protected function resolve($driver)
    {
        $options = $this->getOptions($driver);

        if (isset($this->customCreators[$options['driver']])) {
            return $this->callCustomCreator($options);
        }

        $driverMethod = 'create'.ucfirst($options['driver']).'Challenge';

        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($options);
        } else {
            throw new InvalidArgumentException("Driver [{$options['driver']}] is not supported.");
        }
    }

    /**
     * Call a custom driver creator.
     *
     * @param  array  $options
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected function callCustomCreator(array $options)
    {
        return $this->customCreators[$options['driver']]($this->app, $options);
    }

    /**
     * Get options by driver
     * 
     * @param  string $driver
     * @return array|null
     */
    protected function getOptions($driver)
    {
        return $this->app['config']["inoplate.captcha.drivers.{$driver}"];
    }

    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['inoplate.captcha.challenge'];
    }

    /**
     * Set the default cache driver name.
     *
     * @param  string  $driver
     * @return void
     */
    public function setDefaultDriver($driver)
    {
        $this->app['config']['inoplate.captcha.challenge'] = $driver;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->drive(), $method], $parameters);
    }
}
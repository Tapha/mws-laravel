<?php namespace Mws\Laravel;

use Illuminate\Support\ServiceProvider;

class MwsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Set up the publishing of configuration
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../amazon-config.php' => config_path('mws.php')
        ]);
    }

    /**
     * Register the Mws Instances to be set up with the API-key.
     * Then, the IoC-container can be used to get Mws instances ready for use.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('AmazonOrderList', function($app) {
            $config = $app['config']['mws'];
            return new AmazonOrderList($s = null, $mock = false, $m = null, $config);
        });
    }
}
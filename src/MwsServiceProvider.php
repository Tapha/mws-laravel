<?php namespace Mws\Laravel;

use Illuminate\Support\ServiceProvider;
use anlutro\LaravelSettings\Facade as Setting;

class MwsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the Mws Instances to be set up with the API-key.
     * Then, the IoC-container can be used to get Mws instances ready for use.
     *
     * @return void
     */
    public function register()
    {
        //Register Aliases
        foreach (glob(__DIR__.'/Classes/*.php') as $filename) {
            $amz_alias_name = basename($filename, ".php");
            $amz_alias_path = 'Classes'.'/'.$amz_alias_name;
            if ($amz_alias_name != 'environment')
            {
                $this->app->alias($amz_alias_name, $amz_alias_path);
            }
        }
    }

    /**
     * Set up the MWS configuration
     */
    public function boot()
    {
        
        //Set up the MWS configutation as defined in the LaravelSettings Object by app.

        Setting::set("storeName","mystore"); // this will be key for store config, you pass this as an option in setstore() 
        //Setting::set("authToken",""); // required back from 
        Setting::set("merchantId","");  
        Setting::set("marketplaceId","");  
        Setting::set("keyId","");  
        Setting::set("secretKey","");  
        Setting::set("amazonServiceUrl","");  // set to valid node
        Setting::set("muteLog","false");  //dev purpose, make it true on production 

        $this->readyConfig();


    }

    /**
     * Set up MWS configuration for user and add to config 
     */
    private function readyConfig ()
    {
        //Setting values can also be hardcoded within env. variables and pulled in if persistence and use of LaravelSettings is not needed.    
        $configStore = [
            'store' => [
                Setting::get('storeName') => [
                    'merchantId' => Setting::get('merchantId'),
                    'marketplaceId' => Setting::get('marketplaceId'),
                    'keyId' => Setting::get('keyId'),
                    'secretKey' => Setting::get('secretKey'),
                    'AMAZON_SERVICE_URL'=> Setting::get('amazonServiceUrl'),
                    'authToken'=> Setting::get('authToken'),
                ]
            ],
            // Default service URL
            'AMAZON_SERVICE_URL' => 'https://mws.amazonservices.com/',
            'muteLog' => false
        ];

        $config = \App::make('config');
        $key = 'amazon-mws';
        $config->set($key,  $configStore);
        
    }
}
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

        Setting::set("storeName","mystore"); // This will be the key to store the configuration, you pass this as an option to objects you instanstiate with setstore() 
        Setting::set("authToken",""); //Mws Auth Token - For third party users.
        Setting::set("merchantId","");  //Seller ID
        Setting::set("marketplaceId",""); //Marketplace ID 
        Setting::set("keyId","");  //Key ID
        Setting::set("secretKey",""); //Secret Key 
        Setting::set("amazonServiceUrl","");  // Set to your relevant URL if different from default
        Setting::set("muteLog","false");  //To log requests, make it true on production to stop logging.

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
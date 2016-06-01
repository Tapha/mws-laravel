# tapha/mws-laravel
A minimal service provider to set up and use the Amazon MWS API PHP library in Laravel 5.*

For the package dependency that supports this service provider, check https://github.com/CPIGroup/phpAmazonMWS


## How it works

See https://github.com/CPIGroup/phpAmazonMWS. Simply initialize your objects with your new config data (from the config/mws.php file) like so:

$config = config_path('mws.php');
	
```php
$amz = new AmazonOrderList($s = null, $mock = false, $m = null, $config); //store name matches the array key in the config file
$amz->setLimits('Modified', "- 5000 hours");
$amz->setFulfillmentChannelFilter("FBA"); //no Amazon-fulfilled orders
$amz->setOrderStatusFilter(
    	array("Shipped")
    ); 
$amz->setUseToken(); //Amazon sends orders 100 at a time, but we want them all
$amz->fetchOrders();
return $amz->getList();
```

**Better usage example - Coming soon.**

## Setup
**Step 1: Adding the dependency to composer.json**

Add this to your composer.json in your Laravel folder.
Note: Adding this dependency will automatically setup "cpigroup/php-amazon-mws": "~1.2.0" too.

```json
"require": {
    "tapha/mws-laravel": "1.*",
}
```

**Step 2: Register the service provider**

Register the service provider in ```config/app.php``` by inserting into the ```providers``` array

```php
'providers' => [
	Mws\Laravel\MwsServiceProvider::class,
]
```

**Step 3: From the command-line run**

```
php artisan vendor:publish --provider="Mws\Laravel\MwsServiceProvider"
```

This will publish ```config/mws.php``` to your config folder.

**Step 4: Create an empty log.txt file in your app/config folder**

You may delete this file and set the '```$muteLog```' variable in your ```mws.php``` config to true to turn off logging in production.

**Step 5: Edit your .env file and add your mws settings into it. You can then reference them within your config/mws.php file**

**Example coming soon!

**Good to go!**

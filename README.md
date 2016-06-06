# tapha/mws-laravel
A minimal service provider to set up and use the Amazon MWS API PHP library in Laravel 5.*

Forked from https://github.com/CPIGroup/phpAmazonMWS


## How it works - Usage Example

```php
use Mws\Laravel\AmazonOrderList;
```

```php
$amz = new AmazonOrderList(Setting::get('storeName')); //store name matches the array key in the settings
$amz->setLimits('Modified', "- 5000 hours");
$amz->setFulfillmentChannelFilter("FBA"); //no Amazon-fulfilled orders
$amz->setOrderStatusFilter(
    array("Shipped")
    ); 
$amz->setUseToken(); //Amazon sends orders 100 at a time, but we want them all
$amz->fetchOrders();
$amz->getList();
```

See how this all comes together below.

## Setup
**Step 1: Adding the dependency to composer.json**

Add this to your composer.json in your Laravel folder.
Note: Adding this dependency will automatically setup "cpigroup/php-amazon-mws": "~1.2.0" too.

```json
"require": {
    "tapha/mws-laravel": "1.*",
}
```

**Step 2: Register the service providers and alias**

Register the service providers in ```config/app.php``` by inserting into the ```providers``` array

```php
'providers' => [
	anlutro\LaravelSettings\ServiceProvider::class,
	Mws\Laravel\MwsServiceProvider::class,
]
```

Add the following alias to your 'aliases' array ```config/app.php```

```php
'aliases' => [
	'Setting' => 'anlutro\LaravelSettings\Facade'
]
```

**Step 3: From the command-line run**

```
php artisan vendor:publish"
```

This will publish the LaravelSettings config file to the config directory, which will give you control over which storage engine to use as well as some storage-specific settings.

**Step 4: Add your settings to the LaravelSettings Settings Facade in the 'boot' method of the MwsServiceProvider.php file like this**

```php
//Set up the MWS configutation as defined in the LaravelSettings Object by app.

Setting::set("storeName","mystore"); // this will be key for store config, you pass this as an option in setstore() 
Setting::set("authToken",""); // required back from 
Setting::set("merchantId","");  
Setting::set("marketplaceId","");  
Setting::set("keyId","");  
Setting::set("secretKey","");  
Setting::set("amazonServiceUrl","");  // set to valid node
Setting::set("muteLog","false");  //dev purpose, make it true on production 
```

You can then reference them within your app and run Mws API methods like this - Be sure to specify the 'storename' that you set in the 'boot' method as seen below when initialising methods: 

```php
use Mws\Laravel\AmazonOrderList;
```

```php
$amz = new AmazonOrderList(Setting::get('storeName')); //store name matches the array key in the settings
$amz->setLimits('Modified', "- 5000 hours");
$amz->setFulfillmentChannelFilter("FBA"); //no Amazon-fulfilled orders
$amz->setOrderStatusFilter(
    array("Shipped")
    ); 
$amz->setUseToken(); //Amazon sends orders 100 at a time, but we want them all
$amz->fetchOrders();
$amz->getList();
```

The use of the Settings facade allows you to change your settings on the fly, or in the case of multiple users, replace settings with whatever user needs to make an API call at the time. For example, the logged in user.

**Good to go!**

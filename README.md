# tapha/mws-laravel
A minimal service provider to set up and use the MWS API PHP library in Laravel 5.*

For the package dependency that supports this service provider, check https://github.com/CPIGroup/phpAmazonMWS


## How it works
This package contains a service provider, which binds instances of initialized Mws Objects to the IoC-container.

You recieve the Mws Objects through depencency injection already set up with your own Mws API keys and settings.


**Usage example - Coming soon.**


Or you can manually instantiate and object by using:

```$MwsObject = app('MwsObjectName');```


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

**Step 4: Edit your .env file and add your settings into it. You can then reference them within your config/mws.php file**

**Example coming soon!

**Good to go!**

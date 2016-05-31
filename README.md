# skovmand/mailchimp-laravel
A minimal service provider to set up and use the Mailchimp APi v2 PHP library in Laravel v5.*

For Laravel v4 check https://packagist.org/packages/hugofirth/mailchimp


## How it works
This package contains a service provider, which binds an instance of an initialized Mailchimp client to the IoC-container.

You recieve the Mailchimp client through depencency injection already set up with your own API key.


**Usage example**

```php
class NewsletterManager
{
	protected $mailchimp;
	protected $listId = '1234567890';        // Id of newsletter list

	/**
	 * Pull the Mailchimp-instance from the IoC-container.
	 */
	public function __construct(\Mailchimp $mailchimp)
	{
		$this->mailchimp = $mailchimp;
	}

	/**
	 * Access the mailchimp lists API
     * for more info check "https://apidocs.mailchimp.com/api/2.0/lists/subscribe.php"
	 */
	public function addEmailToList($email)
	{
		try {
			$this->mailchimp
				->lists
				->subscribe(
					$this->listId,
					['email' => $email]
				);
        } catch (\Mailchimp_List_AlreadySubscribed $e) {
        	// do something
        } catch (\Mailchimp_Error $e) {
        	// do something
        }
	}
}

```

Or you can manually instantiate the Mailchimp client by using:

```$mailchimp = app('Mailchimp');```


## Setup
**Step 1: Adding the dependency to composer.json**

Add this to your composer.json in your Laravel folder.
Note: Adding this dependency will automatically setup "mailchimp/mailchimp": "~2.0" too.

```json
"require": {
    "skovmand/mailchimp-laravel": "1.*",
}
```

**Step 2: Register the service provider**

Register the service provider in ```config/app.php``` by inserting into the ```providers``` array

```php
'providers' => [
	Skovmand\Mailchimp\MailchimpServiceProvider::class,
]
```

**Step 3: From the command-line run**

```
php artisan vendor:publish --provider="Skovmand\Mailchimp\MailchimpServiceProvider"
```

This will publish ```config/mailchimp.php``` to your config folder.

**Step 4: Edit your .env file**

for more info check "http://kb.mailchimp.com/accounts/management/about-api-keys#Find-or-Generate-Your-API-Key"

```php
MAILCHIMP_API_KEY="your-api-key-here"
```

**Good to go!**

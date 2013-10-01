# Stormpath drop in replacement for Laravel 4 Auth

This is a provider for adding a stormpath driver to your auth system for laravel 4.  
[![endorse](https://api.coderwall.com/bretterer/endorsecount.png)](https://coderwall.com/bretterer)


## What is Stormpath?

![logo](http://ww1.prweb.com/prfiles/2012/03/16/9555878/stormpath_v1_editedCRH2.jpg)

Stormpath is the first easy and secure user management and authentication service for developers.  With a simple REST API integration, developers can reduce development and operations costs, while protecting users with best-in-class security.


## Installation 

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `lamarus/stormpath`.

	"require": {
		"laravel/framework": "4.0.*",
		"lamarus/stormpath": "dev-master"
	},
	"minimum-stability" : "dev"

Next, update Composer from the Terminal:

    composer update

After the command completes, Run the following command

    php artisan config:publish lamarus/stormpath

Then, go to `app/config/packages/lamarus/stormpath/config.php` and put in your `id`, `secret`, and your `applicationId`.

Once you have added your configuration, add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Lamarus\Stormpath\StormpathServiceProvider'

The final step is to change your auth driver.  Open `app/config/auth.php`, and change the driver to `stormpath`



## Usage

This driver replacement has been created to make it easy to replace the current auth.  All the commands are the same and are used just like the current way.

### Examples

    Route::get('attempt', function() {
		$user = Auth::attempt(array('username' => 'test', 'password' => '1234Abcd'));
	});

	Route::get('check',function() {
		Auth::check();
	});

	Route::get('loginUsingId',function() {
		$user = 'xXxXxXxX'; // the id from stormpath for the user
		Auth::loginUsingId($user);
	});

	Route::get('once', function() {
		Auth::once(array('username' => 'test', 'password' => '1234Abcd'));
	});

	Route::get('login', function() {
		$user = new \Lamarus\Stormpath\StormpathUser('https://api.stormpath.com/v1/accounts/xXxXxXxX');
		Auth::login($user);
	});

	Route::get('logout', function() {
		Auth::logout();
	});

<?php namespace Lamarus\Stormpath;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Guard;

class StormpathServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('lamarus/stormpath');
		
		\Auth::extend('stormpath', function() {
		   
		    return new Guard(new Providers\StormpathUserProvider, \App::make('session'));
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		
	}

	

}
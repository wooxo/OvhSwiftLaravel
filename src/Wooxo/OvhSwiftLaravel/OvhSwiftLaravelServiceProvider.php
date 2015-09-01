<?php namespace Wooxo\OvhSwiftLaravel;
use Filesystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class OvhSwiftLaravelServiceProvider extends ServiceProvider {

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
		$this->package('lflaszlo/ovh-swift-laravel');
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('OvhSwiftLaravel', 'Wooxo\OvhSwiftLaravel\OvhSwiftLaravel');
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

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

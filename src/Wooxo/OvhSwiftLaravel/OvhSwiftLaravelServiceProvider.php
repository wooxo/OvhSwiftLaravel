<?php namespace Wooxo\OvhSwiftLaravel;
use Filesystem;
use Illuminate\Support\ServiceProvider;

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
		$this->package('wooxo/ovh-swift-laravel');
		$configPath = __DIR__ . '/../../config/ovh-swift-laravel.php';
		if (function_exists('config_path')) {
			$publishPath = config_path('ovh-swift-laravel.php');
		} else {
			$publishPath = base_path('config/ovh-swift-laravel.php');
		}
		$this->publishes([$configPath => $publishPath], 'config');
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $configPath = __DIR__ . '/../../config/ovh-swift-laravel.php';
        $this->mergeConfigFrom($configPath, 'ovh-swift-laravel');
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

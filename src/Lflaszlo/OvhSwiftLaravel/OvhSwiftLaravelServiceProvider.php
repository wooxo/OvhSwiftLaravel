<?php namespace Lflaszlo\OvhSwiftLaravel;
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
    }

}

<?php namespace Sanatorium\Manufacturers\Providers;

use Cartalyst\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ManufacturerServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register the attributes namespace
		$this->app['platform.attributes.manager']->registerNamespace(
			$this->app['Sanatorium\Manufacturers\Models\Manufacturer']
		);

		// Register the menu manufacturer type
        $this->app['platform.menus.manager']->registerType(
            $this->app['platform.menus.types.manufacturer']
        );

		// Register manufacturer as manufacturer
        AliasLoader::getInstance()->alias('Manufacturer', 'Sanatorium\Manufacturers\Models\Manufacturer'); 

		// Subscribe the registered event handler
		$this->app['events']->subscribe('sanatorium.manufacturers.manufacturer.handler.event');

		// Register the Blade @manufacturers widget
		$this->registerBladeManufacturersWidget();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{
		// Register the repository
		$this->bindIf('sanatorium.manufacturers.manufacturer', 'Sanatorium\Manufacturers\Repositories\Manufacturer\ManufacturerRepository');

		// Register the data handler
		$this->bindIf('sanatorium.manufacturers.manufacturer.handler.data', 'Sanatorium\Manufacturers\Handlers\Manufacturer\ManufacturerDataHandler');

		// Register the event handler
		$this->bindIf('sanatorium.manufacturers.manufacturer.handler.event', 'Sanatorium\Manufacturers\Handlers\Manufacturer\ManufacturerEventHandler');

		// Register the validator
		$this->bindIf('sanatorium.manufacturers.manufacturer.validator', 'Sanatorium\Manufacturers\Validator\Manufacturer\ManufacturerValidator');
		
		// Register the menus 'manufacturer' type
        $this->bindIf('platform.menus.types.manufacturer', 'Sanatorium\Manufacturers\Menus\ManufacturerType', true, false);
	}

	/**
     * Register the Blade @manufacturers widget.
     *
     * @return void
     */
	public function registerBladeManufacturersWidget()
	{
        $this->app['blade.compiler']->directive('manufacturers', function ($value) {
            return "<?php echo Widget::make('sanatorium/manufacturers::manufacturer.show', array$value); ?>";
        });
	}

}

<?php namespace Sanatorium\Manufacturers\Handlers\Manufacturer;

use Illuminate\Events\Dispatcher;
use Sanatorium\Manufacturers\Models\Manufacturer;
use Cartalyst\Support\Handlers\EventHandler as BaseEventHandler;

class ManufacturerEventHandler extends BaseEventHandler implements ManufacturerEventHandlerInterface {

	/**
	 * {@inheritDoc}
	 */
	public function subscribe(Dispatcher $dispatcher)
	{
		$dispatcher->listen('sanatorium.manufacturers.manufacturer.creating', __CLASS__.'@creating');
		$dispatcher->listen('sanatorium.manufacturers.manufacturer.created', __CLASS__.'@created');

		$dispatcher->listen('sanatorium.manufacturers.manufacturer.updating', __CLASS__.'@updating');
		$dispatcher->listen('sanatorium.manufacturers.manufacturer.updated', __CLASS__.'@updated');

		$dispatcher->listen('sanatorium.manufacturers.manufacturer.deleted', __CLASS__.'@deleted');
	}

	/**
	 * {@inheritDoc}
	 */
	public function creating(array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function created(Manufacturer $manufacturer)
	{
		$this->flushCache($manufacturer);
	}

	/**
	 * {@inheritDoc}
	 */
	public function updating(Manufacturer $manufacturer, array $data)
	{

	}

	/**
	 * {@inheritDoc}
	 */
	public function updated(Manufacturer $manufacturer)
	{
		$this->flushCache($manufacturer);
	}

	/**
	 * {@inheritDoc}
	 */
	public function deleted(Manufacturer $manufacturer)
	{
		$this->flushCache($manufacturer);
	}

	/**
	 * Flush the cache.
	 *
	 * @param  \Sanatorium\Manufacturers\Models\Manufacturer  $manufacturer
	 * @return void
	 */
	protected function flushCache(Manufacturer $manufacturer)
	{
		$this->app['cache']->forget('sanatorium.manufacturers.manufacturer.all');

		$this->app['cache']->forget('sanatorium.manufacturers.manufacturer.'.$manufacturer->id);
	}

}

<?php namespace Sanatorium\Manufacturers\Handlers\Manufacturer;

use Sanatorium\Manufacturers\Models\Manufacturer;
use Cartalyst\Support\Handlers\EventHandlerInterface as BaseEventHandlerInterface;

interface ManufacturerEventHandlerInterface extends BaseEventHandlerInterface {

	/**
	 * When a manufacturer is being created.
	 *
	 * @param  array  $data
	 * @return mixed
	 */
	public function creating(array $data);

	/**
	 * When a manufacturer is created.
	 *
	 * @param  \Sanatorium\Manufacturers\Models\Manufacturer  $manufacturer
	 * @return mixed
	 */
	public function created(Manufacturer $manufacturer);

	/**
	 * When a manufacturer is being updated.
	 *
	 * @param  \Sanatorium\Manufacturers\Models\Manufacturer  $manufacturer
	 * @param  array  $data
	 * @return mixed
	 */
	public function updating(Manufacturer $manufacturer, array $data);

	/**
	 * When a manufacturer is updated.
	 *
	 * @param  \Sanatorium\Manufacturers\Models\Manufacturer  $manufacturer
	 * @return mixed
	 */
	public function updated(Manufacturer $manufacturer);

	/**
	 * When a manufacturer is deleted.
	 *
	 * @param  \Sanatorium\Manufacturers\Models\Manufacturer  $manufacturer
	 * @return mixed
	 */
	public function deleted(Manufacturer $manufacturer);

}

<?php namespace Sanatorium\Manufacturers\Repositories\Manufacturer;

use Cartalyst\Support\Traits;
use Illuminate\Container\Container;
use Symfony\Component\Finder\Finder;

class ManufacturerRepository implements ManufacturerRepositoryInterface {

	use Traits\ContainerTrait, Traits\EventTrait, Traits\RepositoryTrait, Traits\ValidatorTrait;

	/**
	 * The Data handler.
	 *
	 * @var \Sanatorium\Manufacturers\Handlers\Manufacturer\ManufacturerDataHandlerInterface
	 */
	protected $data;

	/**
	 * The Eloquent manufacturers model.
	 *
	 * @var string
	 */
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param  \Illuminate\Container\Container  $app
	 * @return void
	 */
	public function __construct(Container $app)
	{
		$this->setContainer($app);

		$this->setDispatcher($app['events']);

		$this->data = $app['sanatorium.manufacturers.manufacturer.handler.data'];

		$this->setValidator($app['sanatorium.manufacturers.manufacturer.validator']);

		$this->setModel(get_class($app['Sanatorium\Manufacturers\Models\Manufacturer']));
	}

	/**
	 * {@inheritDoc}
	 */
	public function grid()
	{
		return $this
			->createModel();
	}

	/**
	 * {@inheritDoc}
	 */
	public function findAll()
	{
		return $this->container['cache']->rememberForever('sanatorium.manufacturers.manufacturer.all', function()
		{
			return $this->createModel()->get();
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function find($id)
	{
		return $this->container['cache']->rememberForever('sanatorium.manufacturers.manufacturer.'.$id, function() use ($id)
		{
			return $this->createModel()->find($id);
		});
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForCreation(array $input)
	{
		return $this->validator->on('create')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function validForUpdate($id, array $input)
	{
		return $this->validator->on('update')->validate($input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function store($id, array $input)
	{
		return ! $id ? $this->create($input) : $this->update($id, $input);
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(array $input)
	{
		// Create a new manufacturer
		$manufacturer = $this->createModel();

		// Fire the 'sanatorium.manufacturers.manufacturer.creating' event
		if ($this->fireEvent('sanatorium.manufacturers.manufacturer.creating', [ $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForCreation($data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Save the manufacturer
			$manufacturer->fill($data)->save();

			// Resluggify
            if ( method_exists($manufacturer, 'resluggify') )
            	$manufacturer->resluggify()->save();

			// Fire the 'sanatorium.manufacturers.manufacturer.created' event
			$this->fireEvent('sanatorium.manufacturers.manufacturer.created', [ $manufacturer ]);
		}

		return [ $messages, $manufacturer ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update($id, array $input)
	{
		// Get the manufacturer object
		$manufacturer = $this->find($id);

		// Fire the 'sanatorium.manufacturers.manufacturer.updating' event
		if ($this->fireEvent('sanatorium.manufacturers.manufacturer.updating', [ $manufacturer, $input ]) === false)
		{
			return false;
		}

		// Prepare the submitted data
		$data = $this->data->prepare($input);

		// Validate the submitted data
		$messages = $this->validForUpdate($manufacturer, $data);

		// Check if the validation returned any errors
		if ($messages->isEmpty())
		{
			// Update the manufacturer
			$manufacturer->fill($data)->save();

			// Resluggify
            if ( method_exists($manufacturer, 'resluggify') )
            	$manufacturer->resluggify()->save();

			// Fire the 'sanatorium.manufacturers.manufacturer.updated' event
			$this->fireEvent('sanatorium.manufacturers.manufacturer.updated', [ $manufacturer ]);
		}

		return [ $messages, $manufacturer ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function delete($id)
	{
		// Check if the manufacturer exists
		if ($manufacturer = $this->find($id))
		{
			// Fire the 'sanatorium.manufacturers.manufacturer.deleted' event
			$this->fireEvent('sanatorium.manufacturers.manufacturer.deleted', [ $manufacturer ]);

			// Delete the manufacturer entry
			$manufacturer->delete();

			return true;
		}

		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function enable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => true ]);
	}

	/**
	 * {@inheritDoc}
	 */
	public function disable($id)
	{
		$this->validator->bypass();

		return $this->update($id, [ 'enabled' => false ]);
	}

}

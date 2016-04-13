<?php namespace Sanatorium\Manufacturers\Controllers\Admin;

use Platform\Access\Controllers\AdminController;
use Sanatorium\Manufacturers\Repositories\Manufacturer\ManufacturerRepositoryInterface;

class ManufacturersController extends AdminController {

	/**
	 * {@inheritDoc}
	 */
	protected $csrfWhitelist = [
		'executeAction',
	];

	/**
	 * The Manufacturers repository.
	 *
	 * @var \Sanatorium\Manufacturers\Repositories\Manufacturer\ManufacturerRepositoryInterface
	 */
	protected $manufacturers;

	/**
	 * Holds all the mass actions we can execute.
	 *
	 * @var array
	 */
	protected $actions = [
		'delete',
		'enable',
		'disable',
	];

	/**
	 * Constructor.
	 *
	 * @param  \Sanatorium\Manufacturers\Repositories\Manufacturer\ManufacturerRepositoryInterface  $manufacturers
	 * @return void
	 */
	public function __construct(ManufacturerRepositoryInterface $manufacturers)
	{
		parent::__construct();

		$this->manufacturers = $manufacturers;
	}

	/**
	 * Display a listing of manufacturers.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/manufacturers::manufacturers.index');
	}

	/**
	 * Datasource for the manufacturers Data Grid.
	 *
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	public function grid()
	{
		$data = $this->manufacturers->grid();

		$columns = [
			'*',
		];

		$settings = [
			'sort'      => 'created_at',
			'direction' => 'desc',
		];

		$transformer = function($element)
		{
			$element->edit_uri = route('admin.sanatorium.manufacturers.manufacturers.edit', $element->id);

			return $element;
		};

		return datagrid($data, $columns, $settings, $transformer);
	}

	/**
	 * Show the form for creating new manufacturers.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return $this->showForm('create');
	}

	/**
	 * Handle posting of the form for creating new manufacturers.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		return $this->processForm('create');
	}

	/**
	 * Show the form for updating manufacturers.
	 *
	 * @param  int  $id
	 * @return mixed
	 */
	public function edit($id)
	{
		return $this->showForm('update', $id);
	}

	/**
	 * Handle posting of the form for updating manufacturers.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($id)
	{
		return $this->processForm('update', $id);
	}

	/**
	 * Remove the specified manufacturers.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($id)
	{
		$type = $this->manufacturers->delete($id) ? 'success' : 'error';

		$this->alerts->{$type}(
			trans("sanatorium/manufacturers::manufacturers/message.{$type}.delete")
		);

		return redirect()->route('admin.sanatorium.manufacturers.manufacturers.all');
	}

	/**
	 * Executes the mass action.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function executeAction()
	{
		$action = request()->input('action');

		if (in_array($action, $this->actions))
		{
			foreach (request()->input('rows', []) as $row)
			{
				$this->manufacturers->{$action}($row);
			}

			return response('Success');
		}

		return response('Failed', 500);
	}

	/**
	 * Shows the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return mixed
	 */
	protected function showForm($mode, $id = null)
	{
		// Do we have a manufacturers identifier?
		if (isset($id))
		{
			if ( ! $manufacturer = $this->manufacturers->find($id))
			{
				$this->alerts->error(trans('sanatorium/manufacturers::manufacturers/message.not_found', compact('id')));

				return redirect()->route('admin.sanatorium.manufacturers.manufacturers.all');
			}
		}
		else
		{
			$manufacturer = $this->manufacturers->createModel();
		}

		// Show the page
		return view('sanatorium/manufacturers::manufacturers.form', compact('mode', 'manufacturer'));
	}

	/**
	 * Processes the form.
	 *
	 * @param  string  $mode
	 * @param  int  $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function processForm($mode, $id = null)
	{
		// Store the manufacturers
		list($messages) = $this->manufacturers->store($id, request()->all());

		// Do we have any errors?
		if ($messages->isEmpty())
		{
			$this->alerts->success(trans("sanatorium/manufacturers::manufacturers/message.success.{$mode}"));

			return redirect()->route('admin.sanatorium.manufacturers.manufacturers.all');
		}

		$this->alerts->error($messages, 'form');

		return redirect()->back()->withInput();
	}

}

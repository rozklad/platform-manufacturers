<?php namespace Sanatorium\Manufacturers\Repositories\Manufacturer;

interface ManufacturerRepositoryInterface {

	/**
	 * Returns a dataset compatible with data grid.
	 *
	 * @return \Sanatorium\Manufacturers\Models\Manufacturer
	 */
	public function grid();

	/**
	 * Returns all the manufacturers entries.
	 *
	 * @return \Sanatorium\Manufacturers\Models\Manufacturer
	 */
	public function findAll();

	/**
	 * Returns a manufacturers entry by its primary key.
	 *
	 * @param  int  $id
	 * @return \Sanatorium\Manufacturers\Models\Manufacturer
	 */
	public function find($id);

	/**
	 * Determines if the given manufacturers is valid for creation.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForCreation(array $data);

	/**
	 * Determines if the given manufacturers is valid for update.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Illuminate\Support\MessageBag
	 */
	public function validForUpdate($id, array $data);

	/**
	 * Creates or updates the given manufacturers.
	 *
	 * @param  int  $id
	 * @param  array  $input
	 * @return bool|array
	 */
	public function store($id, array $input);

	/**
	 * Creates a manufacturers entry with the given data.
	 *
	 * @param  array  $data
	 * @return \Sanatorium\Manufacturers\Models\Manufacturer
	 */
	public function create(array $data);

	/**
	 * Updates the manufacturers entry with the given data.
	 *
	 * @param  int  $id
	 * @param  array  $data
	 * @return \Sanatorium\Manufacturers\Models\Manufacturer
	 */
	public function update($id, array $data);

	/**
	 * Deletes the manufacturers entry.
	 *
	 * @param  int  $id
	 * @return bool
	 */
	public function delete($id);

}

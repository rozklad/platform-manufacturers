<?php namespace Sanatorium\Manufacturers\Widgets;



class Manufacturer {

	public function show($object, $multiple = false)
	{
		// Get Manufacturers
		$this->manufacturers = app('Sanatorium\Manufacturers\Repositories\Manufacturer\ManufacturerRepositoryInterface');

		// Get current active manufacturers
		$active_manufacturers = $object->manufacturers->pluck('id')->toArray();

		// Manufacturers
		$manufacturers = $this->manufacturers->all();

		return view('sanatorium/manufacturers::widgets/form', compact('object', 'manufacturers', 'active_manufacturers', 'multiple'));
	}

}

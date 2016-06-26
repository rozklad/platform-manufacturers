<?php namespace Sanatorium\Manufacturers\Traits;

trait ManufacturerTrait {

	public function manufacturers()
    {
        return $this->morphToMany('Sanatorium\Manufacturers\Models\Manufacturer', 'manufacturized', 'manufacturized');
    }

}
<?php namespace Sanatorium\Manufacturers\Models;

use Cartalyst\Attributes\EntityInterface;
use Illuminate\Database\Eloquent\Model;
use Platform\Attributes\Traits\EntityTrait;
use Cartalyst\Support\Traits\NamespacedEntityTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Sanatorium\Inputs\Traits\MediableTrait;

class Manufacturer extends Model implements EntityInterface {

	use EntityTrait, NamespacedEntityTrait, SluggableTrait, MediableTrait;

	protected $sluggable = [
        'build_from' => 'manufacturer_title',
        'save_to'    => 'slug',
    ];

	/**
	 * {@inheritDoc}
	 */
	protected $table = 'shop_manufacturers';

	/**
	 * {@inheritDoc}
	 */
	protected $guarded = [
		'id',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $with = [
		'values.attribute',
	];

	/**
	 * {@inheritDoc}
	 */
	protected static $entityNamespace = 'sanatorium/manufacturers.manufacturer';

	public function getUrlAttribute()
	{
		return route('sanatorium.manufacturers.manufacturers.view', ['slug' => $this->slug]);
	}

	public function getLogoAttribute()
	{
		if ( $this->mediaByTag('manufacturer_logo')->count() == 0 )
			return false;

		return $this->mediaByTag('manufacturer_logo')->first(); 
	}

}

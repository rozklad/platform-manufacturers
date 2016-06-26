<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopManufacturizedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manufacturized', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('manufacturized_type');
			$table->integer('manufacturized_id');
			$table->integer('manufacturer_id');
			$table->timestamps();
		});

		// Add attributes
		$this->attributes = app('Platform\Attributes\Repositories\AttributeRepositoryInterface');

		$attributes = [
			[
				'namespace' => \Sanatorium\Manufacturers\Models\Manufacturer::getEntityNamespace(),
				'type' => 'text',
				'slug' => 'manufacturer_title',
				'name' => 'Manufacturer title',
				'description' => 'Manufacturer title',
				'enabled' => 1
			],
			[
				'namespace' => \Sanatorium\Manufacturers\Models\Manufacturer::getEntityNamespace(),
				'type' => 'image',
				'slug' => 'manufacturer_logo',
				'name' => 'Manufacturer logo',
				'description' => 'Manufacturer logo',
				'enabled' => 1
			],
		];

		foreach( $attributes as $attribute ) {

			extract($attribute);

			$attribute_exists = $this->attributes->where('slug', $slug)->count() > 0;

			if ( !$attribute_exists ) {
				$this->attributes->create([
					'namespace' 	=> $namespace,
					'name'      	=> $name,
					'description'	=> $description,
					'type'      	=> $type,
					'slug'      	=> $slug,
					'enabled'   	=> $enabled,
					]);
			}

		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manufacturized');
	}

}

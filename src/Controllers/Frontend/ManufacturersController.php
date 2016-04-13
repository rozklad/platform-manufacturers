<?php namespace Sanatorium\Manufacturers\Controllers\Frontend;

use Platform\Foundation\Controllers\Controller;
use Sanatorium\Manufacturers\Models\Manufacturer;
use Product;

class ManufacturersController extends Controller {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return view('sanatorium/manufacturers::index');
	}

	public function manufacturerBySlug($slug = null)
	{
		return $this->manufacturer(Manufacturer::where('slug', $slug)->first());
	}

	public function manufacturer(Manufacturer $manufacturer, $per_page = 0)
	{
		return view('sanatorium/manufacturers::index', [
				'products' => Product::whereHas('manufacturers', function($q) use ($manufacturer)
				{
					$q->where('shop_manufacturized.manufacturer_id', $manufacturer->id);
				})->ordered()->paginate(config('sanatorium-shop.per_page')),
				'manufacturer' => $manufacturer,
				'per_page' => config('sanatorium-shop.per_page')
			]);
	}

}

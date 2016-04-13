<?php

namespace Sanatorium\Manufacturers\Menus;

use Platform\Menus\Models\Menu;
use Platform\Menus\Types\AbstractType;
use Platform\Menus\Types\TypeInterface;

class ManufacturerType extends AbstractType implements TypeInterface
{
    /**
     * Holds all the available manufacturers.
     *
     * @var \Sanatorium\Manufacturers\Models\Manufacturer
     */
    protected $manufacturers = null;

    /**
     * {@inheritDoc}
     */
    public function getIdentifier()
    {
        return 'manufacturer';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'Manufacturer';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormHtml(Menu $child = null)
    {
        $manufacturers = $this->getCategories();

        return $this->view->make("sanatorium/manufacturers::types/form", compact('child', 'manufacturers'));
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateHtml()
    {
        $manufacturers = $this->getCategories();

        return $this->view->make("sanatorium/manufacturers::types/template", compact('manufacturers'));
    }

    /**
     * {@inheritDoc}
     */
    public function afterSave(Menu $child)
    {
        $data = $child->getAttributes();

        if ($manufacturerId = array_get($data, 'manufacturer_id')) {
            $manufacturer = $this->app['sanatorium.manufacturers.manufacturer']->find($manufacturerId);

            $child->manufacturer_id = $manufacturerId;

            $child->uri = $manufacturer->uri;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function beforeDelete(Menu $child)
    {
    }

    /**
     * Return all the available manufacturers.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getCategories()
    {
        if (! is_null($this->manufacturers)) {
            return $this->manufacturers;
        }

        $manufacturers = $this->app['sanatorium.manufacturers.manufacturer']->findAll();

        foreach ($manufacturers as $manufacturer) {
            $manufacturer->uri = $manufacturer->url === '/' ? null : $manufacturer->url;
        }

        return $this->manufacturers = $manufacturers;
    }
}

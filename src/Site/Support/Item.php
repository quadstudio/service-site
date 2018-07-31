<?php

namespace QuadStudio\Service\Site\Support;

use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Contracts\Buyable;
use ReflectionClass;

class Item implements Buyable
{
    /**
     * @var Item
     */
    protected $product_id;
    protected $name;
    protected $price;
    protected $image = null;
    protected $url = null;
    protected $weight = null;
    protected $unit = null;
    protected $currency_id = null;
    protected $brand_id = null;
    protected $brand = null;
    protected $availability = null;
    protected $sku = null;
    protected $service = 0;
    protected $properties = [];
    protected $quantity = 0;


    public function __construct(array $item)
    {

        $this->properties = new Collection();

        foreach ($item as $key => $value) {
            if (property_exists($this, $key) && !in_array($key, ['properties'])) {
                $this->{$key} = $value;
            } else {
                $this->properties->put($key, $value);
            }
        }
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        return null;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $reflectionClass = new ReflectionClass(get_class($this));
        $array = array();
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->name == 'properties' ? $property->getValue($this)->toJson() : $property->getValue($this);
            $property->setAccessible(false);
        }

        return $array;
    }

    /**
     * @return string
     */
    public function url()
    {
        if (config('cart.url') === true) {
            if ($this->hasUrl()) {
                return $this->url;
            }
        }

        return 'javascript:void(0);';
    }

    /**
     * @return bool
     */
    public function hasUrl()
    {
        return !is_null($this->url);
    }

    /**
     * @param $property
     * @return bool
     */
    public function hasProperty($property)
    {
        return $this->properties->has($property);
    }

    /**
     * @return bool
     */
    public function hasImage()
    {
        return !is_null($this->image);
    }

    /**
     * @return bool
     */
    public function hasService()
    {
        return !is_null($this->service);
    }

    public function hasSku()
    {
        return !is_null($this->sku);
    }

    public function hasWeight()
    {
        return !is_null($this->weight);
    }

    public function hasUnit()
    {
        return !is_null($this->unit);
    }


    public function hasBrand()
    {
        return !is_null($this->brand);
    }

    public function setQuantity($quantity = 1)
    {
        $this->quantity = $quantity;
    }

    public function updateQuantity($quantity = 1)
    {
        $this->quantity += $quantity;
    }

    function quantity()
    {
        return $this->quantity;
    }

    function subtotal()
    {
        return $this->quantity * $this->price;
    }

    function weight()
    {
        return $this->quantity * $this->weight;
    }
}
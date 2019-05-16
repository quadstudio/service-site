<?php

namespace QuadStudio\Service\Site\Concerns;

trait AttachProducts
{
    /**
     * Attach multiple products to a user
     *
     * @param mixed $products
     */
    public function attachProducts(array $products)
    {
        foreach ($products as $product) {
            $this->attachProduct($product);
        }
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $product
     */
    public function attachProduct($product)
    {
        if (is_object($product)) {
            $product = $product->getKey();
        }
        if (is_array($product)) {
            $product = $product['id'];
        }
        $this->products()->attach($product);
    }

    /**
     * Detach multiple products from a user
     *
     * @param mixed $products
     */
    public function detachProducts(array $products)
    {
        if (!$products) {
            $products = $this->products()->get();
        }
        foreach ($products as $product) {
            $this->detachProduct($product);
        }
    }

    /**
     * @param $products
     */
    public function syncProducts($products)
    {
        if (!is_array($products)) {
            $products = [$products];
        }
        $this->products()->sync($products);
    }


    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $product
     */
    public function detachProduct($product)
    {
        if (is_object($product)) {
            $product = $product->getKey();
        }
        if (is_array($product)) {
            $product = $product['id'];
        }
        $this->products()->detach($product);
    }
}
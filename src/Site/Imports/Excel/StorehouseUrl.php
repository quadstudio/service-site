<?php

namespace QuadStudio\Service\Site\Imports\Excel;

use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseUrl
{
    private $_data = [];

    /**
     * @param Storehouse $storehouse
     * @return array
     */
    public function get(Storehouse $storehouse)
    {

        $url = $storehouse->getAttribute('url');

        if (url_exists($url)) {
            $upload = simplexml_load_file($url);
            if ($upload !== false) {
                $i = 0;
                foreach ($upload->shop->offers->offer as $key => $offer) {


                    if ($i >= 5) {
                        break;
                    }

                    $sku = (string)trim($offer->vendorCode);

                    /** @var Product $product */
                    $product = Product::query()->where('sku', $sku)->firstOrFail();

                    $quantity = (int)$offer->price;


                    array_push($this->_data, [
                        'product_id' => $product->getKey(),
                        'quantity'   => $quantity,
                    ]);
                    $i++;
                }


            }
        }

        return $this->_data;
    }
}

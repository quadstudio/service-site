<?php

namespace QuadStudio\Service\Site\Rules;

use Illuminate\Contracts\Validation\Rule;
use QuadStudio\Service\Site\Models\Product;

class StorehouseUrlLoad implements Rule
{

    private $_errors = [];
    private $_data = [];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  string $url
     * @return bool
     */
    public function passes($attribute, $url)
    {
        try {
            $data = [];
            $errors = [];
            $sku = collect([]);

            if (!url_exists($url)) {
                throw new \Exception(trans('site::messages.error.url_not_exists'));
            } else {
                $upload = simplexml_load_file($url);
                if ($upload === false) {
                    throw new \Exception(trans('site::messages.error.xml_load_failed'));
                } else {

                    if (empty($upload->shop->offers->offer)) {
                        throw new \Exception(trans('site::storehouse_product.error.load.empty'));
                    } else {
                        $i = 0;
                        foreach ($upload->shop->offers->offer as $offer) {
                            if ($i >= 20) {
                                break;
                            }

                            if (isset($offer['id'])) {

                                $id = (string)$offer['id'];

                                if(empty($offer->vendorCode)) {
                                    $errors[$id]['product_id'] = trans('site::storehouse_product.error.load.artikul_is_null');
                                    $data[$id]['product_id'] = '';
                                } else{
                                    $value = (string)trim($offer->vendorCode);
                                    $data[$id]['product_id'] = $value;
                                    if (!Product::query()->where('sku', $value)->exists()) {
                                        $errors[$id]['product_id'] = trans('site::storehouse_product.error.load.artikul_not_found');
                                    } elseif ($sku->contains($value)) {
                                        $errors[$id]['product_id'] = trans('site::storehouse_product.error.load.duplicate');
                                    } else {
                                        $sku->push($value);

                                    }
                                }
                                if(empty($offer->price)) {
                                    $errors[$id]['quantity'] = trans('site::storehouse_product.error.load.quantity_is_null');
                                    $data[$id]['quantity'] = '';
                                } else{
                                    $value = (int)$offer->price;
                                    $data[$id]['quantity'] = $value;
                                    if ($value - floor($value) !== 0.0) {
                                        $errors[$id]['quantity'] = trans('site::storehouse_product.error.load.quantity_not_integer');
                                    } elseif ($value <= 0) {
                                        $errors[$id]['quantity'] = trans('site::storehouse_product.error.load.quantity_not_positive');
                                    } elseif ($value >= config('site.storehouse_product_max_quantity', 10000)) {
                                        $errors[$id]['quantity'] = trans('site::storehouse_product.error.load.quantity_max');
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                }
            }
            if (!empty($errors)) {

                $this->_errors = view('site::storehouse_product.url', compact('data', 'errors'))->render();

                return false;
            }

            return true;

        } catch (\Exception $exception) {
            $this->_errors[] = $exception->getMessage();
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->_errors;
    }
}
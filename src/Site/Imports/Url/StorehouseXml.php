<?php

namespace QuadStudio\Service\Site\Site\Imports\Url;


use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Site\Contracts\Importable;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\LoadEmptyDataException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\ProductException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\UrlNotExistsException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\XmlLoadFailedException;
use QuadStudio\Service\Site\Site\Support\Import\UrlImport;

class StorehouseXml extends UrlImport
{

	/**
	 * @return \QuadStudio\Service\Site\Site\Contracts\Importable
	 */
	function import(): Importable
	{

		try {
			$url = $this->url();

			if (!is_null($url)) {

				$duplicates = collect([]);

				if (!url_exists($url)) {
					throw new UrlNotExistsException(trans('site::storehouse.error.upload.url_not_exist', compact('url')));
				}

				try {
					$upload = simplexml_load_file($url);
				} catch (\ErrorException $e) {
					throw new XmlLoadFailedException(trans('site::storehouse.error.upload.xml_load_failed', compact('url')));
				}

				if ($upload === false) {
					throw new XmlLoadFailedException(trans('site::storehouse.error.upload.xml_load_failed', compact('url')));
				}

//				$json = json_encode($upload);
//				$array = json_decode($json,TRUE);
//				dd($array);

				if (empty($upload->shop->offers->offer)) {
					throw new LoadEmptyDataException(trans('site::storehouse.error.upload.data_is_empty'));
				}

				foreach ($upload->shop->offers->offer as $offer) {

					if (isset($offer['id'])) {

						$offer_id = (string)$offer['id'];

						$product = null;

						try {

							if ((bool)$offer->vendorCode === false) {

								// Артикул не найден
								throw new ProductException(trans('site::storehouse.error.upload.sku_not_exist', compact('offer_id')));
							}

							if (($model = Product::query()->where('sku', ($sku = trim((string)$offer->vendorCode))))->doesntExist()) {

								// Товар не найден
								throw new ProductException(trans('site::storehouse.error.upload.sku_not_found', compact('sku')));
							}

							$product = $model->first();

							if ($duplicates->contains($sku)) {

								// Найден дубликат
								throw new ProductException(trans('site::storehouse.error.upload.sku_duplicate_found', compact('sku', 'offer_id')));
							}

							$duplicates->push($sku);

							if ((bool)$offer->quantity === false) {

								// Количество не найдено
								throw new ProductException(trans('site::storehouse.error.upload.quantity_not_exist', compact('sku')));
							}

							if (ctype_digit((string)$offer->quantity) === false) {

								// Количество не является целым числом
								throw new ProductException(trans('site::storehouse.error.upload.quantity_not_integer', compact('sku')));
							}

							if (($quantity = (int)$offer->quantity) <= 0) {

								// Количество меньше нуля
								throw new ProductException(trans('site::storehouse.error.upload.quantity_not_positive', compact('sku')));
							}

							if ($quantity > ($max = config('site.storehouse_product_max_quantity', 20000))) {

								// Количество превышает максимум
								throw new ProductException(trans('site::storehouse.error.upload.quantity_max', compact('max', 'sku')));
							}

							$this->values->put($offer_id, [
								'product_id' => $product->getKey(),
								'quantity' => $quantity,
							]);

						} catch (ProductException $exception) {
							$this->errors->put($offer_id, $exception->getMessage());
						} finally {
							$this->data->put($offer_id, [
								'sku' => (string)$offer->vendorCode,
								'product_id' => isset($product) ? $product->getKey() : $offer_id,
								'name' => isset($product) ? $product->getAttribute('name') : $offer_id,
								'quantity' => (string)$offer->quantity,
							]);
						}
					}
				}
			}
		} catch (\Exception $exception) {
			$this->errors->push($exception->getMessage());
		}

		return $this;

	}
}
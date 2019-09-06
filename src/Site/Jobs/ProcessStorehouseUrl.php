<?php

namespace QuadStudio\Service\Site\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\LoadEmptyDataException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\ProductErrorException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\UrlNotExistsException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\XmlLoadFailedException;

class ProcessStorehouseUrl implements ShouldQueue
{

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var Storehouse
	 */
	private $storehouse;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	private $errors;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	private $products;

	/**
	 * Create a new job instance.
	 *
	 * @param Storehouse $storehouse
	 */
	public function __construct(Storehouse $storehouse)
	{
		$this->storehouse = $storehouse;
		$this->errors = collect([]);
		$this->products = collect([]);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{

		try {
			$duplicates = collect([]);
			$this->storehouse->update(['tried_at' => now()]);
			$url = $this->storehouse->getAttribute('url');
			if (!is_null($url)) {
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

				if (empty($upload->shop->offers->offer)) {
					throw new LoadEmptyDataException(trans('site::storehouse.error.upload.data_is_empty'));
				}

				foreach ($upload->shop->offers->offer as $offer) {
					$offer_id = (string)$offer['id'];
					if (empty($offer->vendorCode)) {
						$this->errors->push(trans('site::storehouse.error.upload.sku_not_exist', compact('offer_id')));
					} elseif (($model = Product::query()->where('sku', ($sku = trim((string)$offer->vendorCode))))->doesntExist()) {
						$this->errors->push(trans('site::storehouse.error.upload.sku_not_found', compact('sku')));
					} elseif ($duplicates->contains($sku)) {
						$this->errors->push(trans('site::storehouse.error.upload.sku_duplicate_found', compact('sku', 'offer_id')));
					} else {
						$duplicates->push($sku);
						if ((bool)$offer->quantity === false) {
							$this->errors->push(trans('site::storehouse.error.upload.quantity_not_exist', compact('sku')));
						} elseif (ctype_digit((string)$offer->quantity) === false) {
							$this->errors->push(trans('site::storehouse.error.upload.quantity_not_positive', compact('sku')));
						} elseif (($quantity = (int)$offer->quantity) > ($max = config('site.storehouse_product_max_quantity', 20000))) {
							$this->errors->push(trans('site::storehouse.error.upload.quantity_max', compact('max', 'sku')));
						} else {
							$this->products->put($model->first()->getKey(), $quantity);
						}
					}
				}
			}

			if ($this->products->isNotEmpty()) {
				dump($this->products->toArray());
			}

			if ($this->errors->isNotEmpty()) {
				throw new ProductErrorException();
			}

		} catch (Exception $e) {

			$this->failed($e);
		} finally {

			$this->storehouse->update(['tried_at' => null]);
		}

	}

	/**
	 * The job failed to process.
	 *
	 * @param  Exception $exception
	 *
	 * @return void
	 */
	public function failed(Exception $exception)
	{
		$message = $exception instanceof ProductErrorException ? $this->errors->toJson(JSON_UNESCAPED_UNICODE) : json_encode($exception->getMessage(), JSON_UNESCAPED_UNICODE);
		$this->storehouse->createLog($message);
	}
}

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
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\ProductException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\UrlNotExistsException;
use QuadStudio\Service\Site\Site\Exceptions\Storehouse\XmlLoadFailedException;
use QuadStudio\Service\Site\Site\Imports\Url\StorehouseXml;

class ProcessStorehouseUrl implements ShouldQueue
{

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var Storehouse
	 */
	private $storehouse;

	/**
	 * Create a new job instance.
	 *
	 * @param Storehouse $storehouse
	 */
	public function __construct(Storehouse $storehouse)
	{
		$this->storehouse = $storehouse;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->storehouse->updateFromUrl(['log' => true]);
	}

}

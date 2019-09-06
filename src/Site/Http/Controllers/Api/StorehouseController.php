<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Jobs\ProcessStorehouseUrl;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseController extends Controller
{

	public function cron()
	{

		/** @var Builder $storehouse */
		if (($storehouse = Storehouse::uploadRequired())->exists()) {
			ProcessStorehouseUrl::dispatch($storehouse->first());
		}

	}

}

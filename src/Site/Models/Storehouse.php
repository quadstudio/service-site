<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Http\Requests\StorehouseRequest;
use QuadStudio\Service\Site\Imports\Excel\StorehouseUrl;
use QuadStudio\Service\Site\Imports\Excel\StorehouseExcel;
use QuadStudio\Service\Site\Repositories\StorehouseLogRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Storehouse extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'storehouses';
	/**
	 * @var array
	 */
	protected $fillable = ['name', 'url', 'enabled', 'everyday', 'uploaded_at', 'tried_at'];

	/**
	 * @var bool
	 */
	protected $casts = [
		'user_id' => 'integer',
		'name' => 'string',
		'url' => 'string',
		'enabled' => 'boolean',
		'everyday' => 'boolean',
		'uploaded_at' => 'datetime:Y-m-d H:i:s',
	];

	/**
	 * @param $value
	 */
	public function setUploadedAtAttribute($value)
	{
		$this->attributes['uploaded_at'] = $value ? Carbon::createFromFormat('d.m.Y H:i:s', $value) : null;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function addresses()
	{
		return $this->hasMany(Address::class);
	}

	/**
	 * @param StorehouseRequest $request
	 *
	 * @return $this
	 */
	public function attachAddresses(StorehouseRequest $request)
	{
		if ($request->filled('addresses')) {
			Address::query()->findMany($request->input('addresses'))->each(function ($address) {
				$address->update(['storehouse_id' => $this->getKey()]);
			});
		}

		return $this;
	}

	/**
	 * @return bool
	 */
	public function updateFromUrl()
	{
		$data = (new StorehouseUrl())->get($this);
		$this->products()->delete();
		$this->products()->createMany($data);

		return $this->update(['uploaded_at' => date('d.m.Y H:i:s')]);
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 */
	public function updateFromArray(array $data)
	{
		$products = [];
		foreach ($data as $product_id => $quantity) {
			array_push($products, compact('product_id', 'quantity'));
		}
		$this->products()->delete();
		$this->products()->createMany($products);

		return $this->update(['uploaded_at' => date('d.m.Y H:i:s')]);
	}

	/**
	 * @param UploadedFile $path
	 *
	 * @return bool
	 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
	 */
	public function updateFromExcel(UploadedFile $path)
	{
		$data = (new StorehouseExcel())->get($path);
		$this->products()->delete();
		$this->products()->createMany($data);

		return $this->update(['uploaded_at' => date('d.m.Y H:i:s')]);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function uploadRequired()
	{
		return self::query()
			->whereNotNull('url')
			->where('enabled', 1)
			->where('everyday', 1)
			->whereNull('tried_at')
			->where(function ($query) {
				$query
					->whereNull('uploaded_at')
					->orWhereDate('uploaded_at', '<', Carbon::today()->toDateString());
			});
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function products()
	{
		return $this->hasMany(StorehouseProduct::class, 'storehouse_id');
	}

	/**
	 * @return bool
	 */
	public function hasLatestLogErrors()
	{
		return $this->logs()->exists() && (
				is_null($this->getAttribute('uploaded_at'))
				|| $this->logs()->whereDate(
					'created_at',
					'>',
					$this->getAttribute('uploaded_at')->toDateString()
				));
	}

	public function latestLog()
	{
		return $this->logs()->latest()->first();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function logs()
	{
		return $this->hasMany(StorehouseLog::class, 'storehouse_id')->latest();
	}

	public function createLog($message)
	{
		$this->logs()->create([
			'type' => StorehouseLog::TYPE_ERROR,
			'url' => $this->getAttribute('url'),
			'message' => $message,
		]);


	}

}

<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Mail\Storehouse\UserStorehouseLogCreateEmail;

class StorehouseLog extends Model
{

	const TYPE_ERROR = 'error';
	const TYPE_SUCCESS = 'success';

	/**
	 * @var array
	 */
	protected $fillable = ['message', 'url', 'type'];

	/**
	 * @var bool
	 */
	protected $casts = [
		'storehouse_id' => 'integer',
		'message' => 'string',
		'url' => 'string',
		'type' => 'string',
	];

	public static function boot()
	{
		parent::boot();
		static::created(function (StorehouseLog $storehouseLog) {
			Mail::to($storehouseLog->storehouse->user->email)->send(new UserStorehouseLogCreateEmail($storehouseLog));
		});
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function storehouse()
	{
		return $this->belongsTo(Storehouse::class);
	}

	public function getMessageAttribute($value)
	{
		return collect((array)json_decode($value, true));
	}

}

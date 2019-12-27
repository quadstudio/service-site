<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use QuadStudio\Service\Site\Services\Digift;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;

class DigiftBonus extends Model
{

	/**
	 * @var bool
	 */
	public $incrementing = false;
	/**
	 * @var string
	 */
	protected $table = 'digift_bonuses';
	/**
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'operationValue',
		'digiftOperationId',
		'blocked',
		'sended',
		'digift_resp',
		'sended_at',
	];

	/**
	 * @var array
	 */
	protected $casts = [
		'id' => 'string',
		'user_id' => 'string',
		'bonusable_id' => 'integer',
		'bonusable_type' => 'string',
		'operationValue' => 'integer',
		'digiftOperationId' => 'string',
		'blocked' => 'boolean',
		'sended' => 'boolean',
		'digift_resp' => 'string',
		'sended_at' => 'timestamp',

	];

	protected static function boot()
	{
		static::creating(function ($model) {
			$model->id = Str::uuid();
		});
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function digiftUser()
	{
		return $this->belongsTo(DigiftUser::class, 'user_id');
	}

	/**
	 * Get all of the owning contactable models.
	 */
	public function bonusable()
	{
		return $this->morphTo();
	}

	/**
	 * @throws DigiftException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function rollbackBalanceChange()
	{
		if ($this->getAttribute('sended') == 0) {
			$this->update(['blocked' => 1]);
		} else {
			$response = (new Digift())->rollbackBalanceChange(['externalOperationId' => $this->getKey()])->request();
			if ($response->getStatusCode() === Response::HTTP_OK) {
				$body = json_decode($response->getBody(), true);
				if ($body['code'] == 0) {
					$this->update(['blocked' => 1]);
				} else {
					throw new DigiftException($body['message']);
				}
			}
		}

	}

	/**
	 * @throws DigiftException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function changeBalance()
	{

		if ($this->getAttribute('sended') == 0) {
			$this->update(['sended_at' => now()]);
			$data = [
				'id' => $this->getAttribute('user_id'),
				'operationType' => 'increase',
				'operationValue' => $this->getAttribute('operationValue'),
				'externalOperationId' => $this->getKey(),
			];

			$response = (new Digift())->changeBalance($data)->request();
			if ($response->getStatusCode() === Response::HTTP_OK) {

				$body = json_decode($response->getBody(), true);
				if ($body['code'] == 0) {
					$this->update(['sended' => 1, 'digift_resp' => $body['message']]);
				} else {
					throw new DigiftException($body['message']);
				}
			} else {
				throw new DigiftException($response->getReasonPhrase());
			}
		} else {
			throw new DigiftException(trans('site::digift_bonus.error.alreadySended'));
		}
	}

	/**
	 * @return mixed
	 */
	public function getTotalAttribute()
	{
		return $this->newQuery()->where('blocked', 0)->sum('operationValue');
	}
}

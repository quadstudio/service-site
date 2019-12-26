<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DigiftExpense extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'digift_expenses';

	/**
	 * @var bool
	 */
	public $incrementing = false;

	/**
	 * @var array
	 */
	protected $fillable = [
		'id',
		'user_id',
		'operationValue'
	];

	/**
	 * @var array
	 */
	protected $casts = [
		'id' => 'string',
		'user_id' => 'string',
		'operationValue' => 'integer',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function digiftUser()
	{
		return $this->belongsTo(DigiftUser::class, 'user_id');
	}

}

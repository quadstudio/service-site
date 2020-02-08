<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{

	/**
	 * @var bool
	 */
	public $incrementing = false;
	/**
	 * @var array
	 */
	protected $fillable = ['id', 'name', 'created_at', 'type_id', 'organization'];

	/**
	 * @var array
	 */
	protected $casts = [
		'id' => 'string',
		'name' => 'string',
		'organization' => 'string',
		'type_id' => 'integer',
		'engineer_id' => 'integer',
	];

	/**
	 * @var string
	 */
	protected $table = 'certificates';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function engineer()
	{
		return $this->belongsTo(Engineer::class);
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function type()
	{
		return $this->belongsTo(CertificateType::class);
	}

}

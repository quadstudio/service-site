<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'serials';

    public $incrementing = false;

    /**
     * Тип файла
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}

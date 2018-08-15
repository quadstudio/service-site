<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    /**
     * @var array id
     */
    protected $fillable = [
        'ks', 'bank', 'city',
        'address', 'phones', 'inn',
        'disabled', 'date',
    ];

    /**
     * @var string
     */
    protected $table;

    public $incrementing = false;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'banks';
    }

}

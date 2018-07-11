<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Datasheet extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [

    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'datasheets';
    }

}

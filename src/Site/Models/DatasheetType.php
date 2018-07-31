<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class DatasheetType extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'datasheet_types';
    }

}

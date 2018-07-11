<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'cost_work', 'cost_road', 'currency_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'costs';
    }

}

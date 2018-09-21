<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class RepairFail extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'field', 'comment'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'repair_fails';
    }

}

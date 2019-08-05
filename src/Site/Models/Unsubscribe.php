<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Unsubscribe extends Model
{

    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'unsubscribes';
    }

}

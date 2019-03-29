<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;


class FileMime extends Model
{

    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = ['name', 'mime', 'accept'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'file_mimes';
    }
}

<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class DatasheetType extends Model
{
    /**
     * @var string
     */
    protected $table = 'datasheet_types';

    protected $fillable = [
        'name'
    ];

}

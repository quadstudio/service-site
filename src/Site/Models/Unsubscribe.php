<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Unsubscribe extends Model
{

    /**
     * @var string
     */
    protected $table = 'unsubscribes';
    /**
     * @var array
     */
    protected $fillable = ['email'];

}

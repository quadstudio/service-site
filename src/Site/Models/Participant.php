<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name', 'headposition', 'phone', 'email'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'participants';
    }


    /**
     * Заявка
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

}

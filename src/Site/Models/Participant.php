<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Phoneable;

class Participant extends Model
{

    use Phoneable;

    /**
     * @var string
     */
    protected $table = 'participants';

    protected $fillable = [
        'name', 'headposition', 'phone', 'email', 'country_id'
    ];

    /**
     * Заявка
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Страна
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}

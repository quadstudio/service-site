<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ActDetail extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'our', 'name', 'inn', 'kpp', 'okpo',
        'rs', 'ks', 'bik', 'bank', 'nds',
        'nds_act', 'address'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'act_details';
    }

    /**
     * Акт выполненных работ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function act()
    {
        return $this->belongsTo(Act::class);
    }


}

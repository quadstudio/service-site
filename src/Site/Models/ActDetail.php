<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ActDetail extends Model
{
    /**
     * @var string
     */
    protected $table = 'act_details';

    protected $fillable = [
        'our', 'name', 'inn', 'kpp', 'okpo',
        'rs', 'ks', 'bik', 'bank', 'nds',
        'nds_act', 'address', 'nds_value',
        'guid'
    ];

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

<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'period_id', 'number', 'client_name', 'client_address',
        'client_inn', 'client_kpp', 'client_okpo',
        'client_rs', 'client_ks', 'client_bik',
        'client_bank',
        'contract_number', 'contract_date', 'nds',
        'nds_enabled', 'opened', 'our_name',
        'our_address','our_inn','our_kpp',
        'our_rs','our_ks','our_bik',
        'our_bank',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'acts';
    }

    /**
     * Scope a query to only opened acts
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpened($query)
    {
        return $query->where('opened', 1);
    }

}

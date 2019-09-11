<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\SingleFileable;

class ContractType extends Model implements SingleFileable
{
    /**
     * @var string
     */
    protected $table = 'contract_types';

    protected $fillable = [
        'name', 'prefix', 'file_id', 'active',
    ];

    protected $casts = [
        'name'    => 'string',
        'prefix'  => 'string',
        'active'  => 'boolean',
        'file_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    /**
     * Scope a query to only enabled countries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCanCreate($query)
    {
        return $query->where('active', 1)
            ->whereDoesntHave('contracts', function ($contract) {
                $contract->whereHas('contragent', function ($contragent) {
                    $contragent->where('user_id', auth()->user()->getAuthIdentifier());
                });
            });
    }

    /**
     * @return string
     */
    function fileStorage()
    {
        return 'templates';
    }
}

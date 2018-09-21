<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public $incrementing = false;
    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['account_id'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'organizations';
    }

    /**
     * Расчетный счет
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Расчетные счета
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function toArray()
    {
        return [
            'our'     => 1,
            'guid'    => $this->getAttribute('id'),
            'name'    => $this->getAttribute('name'),
            'inn'     => $this->getAttribute('inn'),
            'okpo'    => $this->getAttribute('okpo'),
            'rs'      => $this->getAttribute('rs'),
            'ks'      => $this->getAttribute('ks'),
            'bik'     => $this->getAttribute('bik'),
            'bank'    => $this->getAttribute('bank'),
            'address' => $this->getAttribute('address'),
        ];
    }

}

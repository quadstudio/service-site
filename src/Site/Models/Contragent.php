<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contragent extends Model
{
    protected $fillable = [
        'type_id', 'name', 'nds', 'inn', 'ogrn',
        'okpo', 'kpp', 'rs', 'ks', 'bik', 'bank',
        'organization_id', 'contract'
    ];

    /**
     * @var string
     */
    protected $table;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'contragents';
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->organization_id = config('site.defaults.user.organization_id');
        });
    }

    public function created_at()
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y H:i') : '';
    }

    /**
     * Тип контрагента
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ContragentType::class);
    }

    /**
     * Адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * @return bool
     */
    public function check()
    {
        return mb_strlen($this->getAttribute('name'), 'UTF-8') > 0
            && (
                $this->getAttribute('type_id') == 1
                && strlen($this->getAttribute('inn')) == 10
                || strlen($this->getAttribute('inn')) == 12
            )
            && in_array(strlen($this->getAttribute('ogrn')), [13, 15])
            && in_array(strlen($this->getAttribute('okpo')), [8, 10])
            && (
                $this->getAttribute('type_id') == 2 || strlen($this->getAttribute('kpp')) == 9
            )
            && strlen($this->getAttribute('rs')) == 20
            && in_array(strlen($this->getAttribute('bik')), [9, 11])
            && mb_strlen($this->getAttribute('bank'), 'UTF-8') > 0
            && in_array(strlen($this->getAttribute('ks')), [0, 20])
            && !is_null($this->getAttribute('organization_id'))
            && mb_strlen($this->getAttribute('contract'), 'UTF-8') > 0;
    }

    /**
     * Заказы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Клиент
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Организация
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}

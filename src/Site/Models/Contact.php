<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'type_id', 'name', 'position'
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
        $this->table = env('DB_PREFIX', '') . 'contacts';
    }


    /**
     * Телефоны
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Тип контакта
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ContactType::class);
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

}

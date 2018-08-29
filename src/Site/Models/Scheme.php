<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'block_id', 'datasheet_id', 'image_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'schemes';
    }

    /**
     * Блок
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * Файл взрывной схемы (каталог запчастей в техдокументации)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datasheet()
    {
        return $this->belongsTo(Datasheet::class);
    }

    /**
     * Изображение схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @param $equipment
     * @return $this
     */
    public function attachEquipment($equipment)
    {
        if ($equipment instanceof Equipment) {
            $equipment = $equipment->getKey();
        }
        if (is_array($equipment)) {
            return $this->attachEquipments($equipment);
        }
        $this->equipments()->attach($equipment);

        return $this;
    }

    /**
     * @param array $equipments
     * @return $this
     */
    public function attachEquipments(array $equipments)
    {
        foreach ($equipments as $equipment) {
            $this->attachEquipment($equipment);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function equipments()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_scheme_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_equipments();
            });
        }

        return $this->_equipments();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function _equipments()
    {
        return $this->belongsToMany(
            Equipment::class,
            env('DB_PREFIX', '') . 'equipment_scheme',
            'scheme_id',
            'equipment_id'
        );
    }

    /**
     * Детали схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(Element::class);
    }

}

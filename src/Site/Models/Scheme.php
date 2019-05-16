<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Contracts\SingleImageable;

class Scheme extends Model implements SingleImageable
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
        $this->table = 'schemes';
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
        return $this->belongsTo(Image::class)->withDefault([
            'storage' => 'events',
            'path'    => 'noimage.png',
        ]);
    }

    /**
     * Детали схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(Element::class)->orderBy('sort_order');
    }

    /**
     * @return string
     */
    function imageStorage()
    {
        return 'schemes';
    }
}

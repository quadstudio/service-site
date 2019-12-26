<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['title', 'annotation', 'description', 'image_id', 'date', 'published'];

    protected $casts = [

        'title'       => 'string',
        'annotation'  => 'string',
        'description' => 'string',
        'published'   => 'boolean',
        'image_id'    => 'integer',
        'date'        => 'date',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'news';
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

    /**
     * Изображение схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class)->withDefault([
            'storage' => 'news',
            'path'    => 'noimage.png',
        ]);
    }

    public function hasDescription()
    {
        return mb_strlen($this->getAttribute('description'), "UTF-8") > 0;
    }

}

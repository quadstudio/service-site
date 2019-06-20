<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Sortable;
use QuadStudio\Service\Site\Contracts\SingleImageable;


class EventType extends Model implements SingleImageable
{

    use Sortable;
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name', 'annotation', 'description',
        'route', 'sort_order', 'image_id',
        'meta_description', 'title',
        'show_ferroli', 'show_lamborghini'
    ];

    protected $casts = [
        'name'             => 'string',
        'title'            => 'string',
        'annotation'       => 'string',
        'description'      => 'string',
        'meta_description' => 'string',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
        'sort_order'       => 'integer',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'event_types';
    }

//    public function resolveRouteBinding($value)
//    {
//        return $this->where('alias', $value)->first() ?? abort(404);
//    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    /**
     * Мероприятия
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'type_id');
    }

    /**
     * Изображение
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class)->withDefault([
            'storage' => 'event_types',
            'path'    => 'noimage.png',
        ]);
    }

    /**
     * @return string
     */
    function imageStorage()
    {
        return 'event_types';
    }
}

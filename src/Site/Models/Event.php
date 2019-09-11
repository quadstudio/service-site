<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use QuadStudio\Service\Site\Contracts\SingleImageable;

class Event extends Model implements SingleImageable
{

	/**
	 * @var string
	 */
	protected $table = 'events';

	/**
	 * @var array
	 */
    protected $fillable = [
        'title', 'annotation', 'description',
        'date_from', 'date_to', 'confirmed',
        'image_id', 'type_id', 'status_id',
        'region_id', 'city', 'address',
        'show_ferroli', 'show_lamborghini'
    ];

	/**
	 * @var array
	 */
    protected $casts = [

        'title'            => 'string',
        'annotation'       => 'string',
        'description'      => 'string',
        'confirmed'        => 'boolean',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
        'image_id'         => 'integer',
        'type_id'          => 'integer',
        'status_id'        => 'integer',
        'region_id'        => 'string',
        'city'             => 'string',
        'address'          => 'string',
        'date_from'        => 'date:Y-m-d',
        'date_to'          => 'date:Y-m-d',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($event) {
            if ($event->image()->exists()) {
                $event->image->delete();
            }
        });
    }

    /**
     * @param $value
     */
    public function setDateFromAttribute($value)
    {
        $this->attributes['date_from'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }

    /**
     * @param $value
     */
    public function setDateToAttribute($value)
    {
        $this->attributes['date_to'] = $value ? Carbon::createFromFormat('d.m.Y', $value) : null;
    }

    /**
     * Изображение
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
     * Тип мероприятия
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(EventType::class);
    }

    /**
     * Статус мероприятия
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(EventStatus::class);
    }

    public function hasDescription()
    {
        return mb_strlen($this->getAttribute('description'), "UTF-8") > 0;
    }

    public function hasAddress()
    {
        return mb_strlen($this->getAttribute('address'), "UTF-8") > 0;
    }

    /**
     * Регион
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Заявки участников
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * @return string
     */
    function imageStorage()
    {
        return 'events';
    }
}

<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Http\Requests\Admin\MailingSendRequest;
use QuadStudio\Service\Site\Mail\Guest\MailingHtmlEmail;

class Event extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'title', 'annotation', 'description',
        'date_from', 'date_to', 'confirmed',
        'image_id', 'type_id', 'status_id',
        'region_id', 'city', 'address',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'events';
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

    /**
     * Дата проведения С
     *
     * @return string
     */
    public function date_from()
    {
        return !is_null($this->getAttribute('date_from')) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->getAttribute('date_from')))->format('d.m.Y') : '';
    }

    /**
     * Дата проведения По
     *
     * @return string
     */
    public function date_to()
    {
        return !is_null($this->getAttribute('date_to')) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->getAttribute('date_to')))->format('d.m.Y') : '';
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

}

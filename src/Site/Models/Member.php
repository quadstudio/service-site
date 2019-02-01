<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'type_id', 'event_id', 'region_id', 'city',
        'name', 'contact', 'phone', 'email', 'count',
        'address', 'date_from', 'date_to', 'status_id',
        'verified', 'verify_token'
    ];

    //protected $dateFormat = 'd.m.Y H:i:s';

    protected $casts = [
        'type_id'      => 'integer',
        'event_id'     => 'integer',
        'status_id'    => 'string',
        'region_id'    => 'string',
        'city'         => 'string',
        'name'         => 'string',
        'phone'        => 'string',
        'contact'      => 'string',
        'count'        => 'integer',
        'email'        => 'string',
        'address'      => 'string',
        'date_from'    => 'date',
        'date_to'      => 'date',
        'verified'     => 'boolean',
        'verify_token' => 'string',
    ];


    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'members';
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function (Member $member) {
            $member->setAttribute('verify_token', str_random(40));
        });
    }

    public function hasVerified()
    {
        $this->setAttribute('verified', true);
        $this->setAttribute('verify_token', null);
        $this->save();
    }

    public function setDateFromAttribute($value)
    {
        $this->attributes['date_from'] = date('Y-m-d', strtotime($value));
    }

    public function setDateToAttribute($value)
    {
        $this->attributes['date_to'] = date('Y-m-d', strtotime($value));
    }


    /**
     * Мероприятие
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class)->withDefault([
            'title' => ''
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
        return $this->belongsTo(MemberStatus::class);
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
     * Желаемая дата С
     *
     * @return string
     */
    public function date_from()
    {
        return \Carbon\Carbon::instance($this->getAttribute('date_from'))->format('d.m.Y');
    }

    /**
     * Желаемая дата По
     *
     * @return string
     */
    public function date_to()
    {
        return \Carbon\Carbon::instance($this->getAttribute('date_to'))->format('d.m.Y');
    }

    /**
     * Участники
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * @return bool
     */
    public function hasAddress()
    {
        return mb_strlen($this->getAttribute('address'), "UTF-8") > 0;
    }


}

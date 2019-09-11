<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use QuadStudio\Service\Site\Concerns\Phoneable;

class Member extends Model
{
    use Phoneable;

	/**
	 * @var string
	 */
	protected $table = 'members';

	/**
	 * @var array
	 */
    protected $fillable = [
        'type_id', 'event_id', 'region_id', 'city',
        'name', 'contact', 'phone', 'email', 'count',
        'address', 'date_from', 'date_to', 'status_id',
        'verified', 'verify_token', 'country_id',
        'show_ferroli', 'show_lamborghini'
    ];
	/**
	 * @var array
	 */
    protected $casts = [
        'type_id'          => 'integer',
        'event_id'         => 'integer',
        'country_id'       => 'integer',
        'status_id'        => 'string',
        'region_id'        => 'string',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
        'city'             => 'string',
        'name'             => 'string',
        'phone'            => 'string',
        'contact'          => 'string',
        'count'            => 'integer',
        'email'            => 'string',
        'address'          => 'string',
        'date_from'        => 'date:Y-m-d',
        'date_to'          => 'date:Y-m-d',
        'verified'         => 'boolean',
        'verify_token'     => 'string',
    ];

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

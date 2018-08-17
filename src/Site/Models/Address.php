<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'type_id', 'country_id', 'region_id',
        'locality', 'street', 'building',
        'apartment', 'postal',
    ];

    /**
     * @var string
     */
    protected $table;

    /**
     * @var \Geocoder\StatefulGeocoder
     */
    private $geocoder;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'addresses';
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function (Address $address) {
            $httpClient = new \Http\Adapter\Guzzle6\Client();
            $provider = new \Geocoder\Provider\Yandex\Yandex($httpClient);
            $geocoder = new \Geocoder\StatefulGeocoder($provider, 'ru');
            $result = [];
            $result[] = $address->country->name;
            $result[] = $address->region->name;
            $result[] = $address->locality;
            $result[] = $address->street;
            $result[] = $address->building;
            $result[] = $address->apartment;
            $name = implode(', ', $result);
            $result = $geocoder->geocodeQuery(\Geocoder\Query\GeocodeQuery::create($name));
            if (!$result->isEmpty()) {
                $geocode = $result->first();
                $address->geo = implode(',', $geocode->getCoordinates()->toArray());
                $formatter = new \Geocoder\Formatter\StringFormatter();
                $address->name = preg_replace(['/\s,/', '/\s+/'], ' ', $formatter->format($geocode, '%A1, %A2, %A3, %L, %D %S, %n'));
            }
        });
    }

    /**
     * Тип адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AddressType::class);
    }

    /**
     * Страна местонахождения
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get all of the owning contactable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Пользователи
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id','addressable_id')->where('addressable_type', 'users');
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

}

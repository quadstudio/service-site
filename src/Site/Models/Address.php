<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Traits\Models\AddressStorehouseTrait;

class Address extends Model
{

    use AddressStorehouseTrait;

    protected $fillable = [
        'type_id', 'country_id', 'region_id',
        'locality', 'street', 'building',
        'apartment', 'postal', 'name', 'active',
        'is_shop', 'is_service', 'is_eshop', 'sort_order',
        'email', 'eshop'
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
        $this->table = 'addresses';
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
            $full = preg_replace('/,\s+$/', '', implode(', ', $result));
            $address->full = $full;
            $result = $geocoder->geocodeQuery(\Geocoder\Query\GeocodeQuery::create($full));
            if (!$result->isEmpty()) {
                $geocode = $result->first();
                $address->geo = implode(',', array_reverse($geocode->getCoordinates()->toArray()));
                //$formatter = new \Geocoder\Formatter\StringFormatter();
                //$name = $formatter->format($geocode, '%A1, %A2, %A3, %L, %D %S, %n');
                //$address->full = preg_replace(['/\s,/', '/\s+/'], ' ', $full);
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

    public function lat()
    {
        list($lat, $lon) = explode(',', $this->geo);

        return (float)$lat;
    }

    public function lon()
    {
        list($lat, $lon) = explode(',', $this->geo);

        return (float)$lon;
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
     * Get all of the owning addressable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     * Телефоны
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    /**
     * Пользователи
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id', 'addressable_id')->where('addressable_type', 'users');
    }

    /**
     * Контрагнеты
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contragents()
    {
        return $this->hasMany(Contragent::class, 'id', 'addressable_id')->where('addressable_type', 'contragents');
    }

    public function hasEmail()
    {
        return !is_null($this->getAttribute('email'));
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
     * Заказы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}

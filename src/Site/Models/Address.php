<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\AttachRegions;

class Address extends Model
{

    use AttachRegions;

    protected $fillable = [
        'type_id', 'country_id', 'region_id',
        'locality', 'street', 'building',
        'apartment', 'postal', 'name',
        'show_ferroli', 'show_lamborghini',
        'is_shop', 'is_service', 'is_eshop', 'is_mounter',
        'sort_order', 'email', 'web'
    ];

    protected $casts = [
        'type_id'          => 'integer',
        'country_id'       => 'integer',
        'region_id'        => 'string',
        'locality'         => 'string',
        'street'           => 'string',
        'name'             => 'string',
        'sort_order'       => 'integer',
        'email'            => 'string',
        'web'              => 'string',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
        'is_shop'          => 'boolean',
        'is_service'       => 'boolean',
        'is_eshop'         => 'boolean',
        'is_mounter'       => 'boolean',
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
     * Many-to-Many relations with region model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function regions()
    {
        return $this->belongsToMany(
            Region::class,
            'address_region',
            'address_id',
            'region_id');
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

    public function getCanEditRegionsAttribute()
    {
        return in_array($this->getAttribute('type_id'), [5, 6]);
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

    /**
     * Заявки на монтаж
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mounters()
    {
        return $this->hasMany(Mounter::class, 'user_address_id');
    }


}

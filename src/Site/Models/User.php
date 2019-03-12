<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Online\OnlineChecker;
use QuadStudio\Rbac\Traits\Models\RbacUserTrait;
use QuadStudio\Service\Site\Contracts\Addressable;
use QuadStudio\Service\Site\Traits\Models\ScheduleTrait;

class User extends Authenticatable implements Addressable
{
    use Notifiable, RbacUserTrait, OnlineChecker, ScheduleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'dealer',
        'display', 'type_id', 'active', 'image_id',
        'warehouse_id', 'currency_id', 'region_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (User $user) {
            $user->verify_token = str_random(40);
            $user->price_type_id = config('site.defaults.user.price_type_id');
            $user->warehouse_id = config('site.defaults.user.warehouse_id');
        });
    }

    /**
     * @return bool
     */
    public function hasGuid()
    {
        return !is_null($this->getAttribute('guid'));
    }

    /**
     * @return string
     */
    public function getLogoAttribute()
    {
        if (is_null($this->image_id)) {
            return Storage::disk('logo')->url('default.png');
        }

        return Storage::disk($this->image->storage)->url($this->image->path);
    }

    /**
     * Логотип
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class)->withDefault([
            'storage' => 'images',
            'path'    => 'logo/default.png',
        ]);
    }


    public function created_at($time = false)
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y' . ($time === true ? ' H:i' : '')) : '';
    }

    public function logged_at()
    {
        //dd($this->logged_at);
        return !is_null($this->logged_at) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d H:i:s', $this->logged_at))->format('d.m.Y H:i') : '';
    }

    public function addresses_count()
    {
        return $this->addresses()->count() + Address::where(function ($query) {
                $query->whereAddressableType('contragents')->whereIn('addressable_id', $this->contragents->pluck('id'));
            })->count();
    }

    /**
     * Адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * @return Address
     */
    public function address()
    {
        return $this->addresses()->where('type_id', 2)->firstOrNew([]);
    }

    /**
     * @return Contact
     */
    public function sc()
    {
        return $this->contacts()->where('type_id', 2)->first();
    }

    /**
     * Контакты
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Акты выполненных работ
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function acts()
    {
        return $this->hasMany(Act::class);
    }

    public function sc_phones()
    {
        $phones = collect([]);
        foreach ($this->contacts()->where('type_id', 2)->get() as $contact) {
            $phones = $phones->merge($contact->phones);
        }

        return $phones;
    }

    /**
     * Организационно-правовая форма
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ContragentType::class);
    }

    /**
     * Основной регион клиента
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Валюта расчетов
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function storehouses(){
        if($this->hasRole('gendistr')){
            return User::query()->find(1)->addresses()->where('type_id', 6)->get();
        }
        return $this->region->storehouses;
    }

    /**
     * Склад
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Контрагенты
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contragents()
    {
        return $this->hasMany(Contragent::class);
    }

    /**
     * Типы цен пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

	 public function prices()
    {
        return $this->hasMany(UserPrice::class);
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function distributors()
    {
        return Order::query()->whereHas('address', function ($query) {
            $query
                ->where('type_id', 6)
                ->where('addressable_id', $this->getAttribute('id'))
                ->where('addressable_type', DB::raw('"users"'));
        });
    }

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Инженеры
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function engineers()
    {
        return $this->hasMany(Engineer::class);
    }

    /**
     * Торговые организации
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    /**
     * Ввод в эксплуатацию
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function launches()
    {
        return $this->hasMany(Launch::class);
    }

    /**
     * Отчеты по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Отправленные сообщения
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outbox()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Полученные сообщения
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inbox()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }


    /**
     * Check user online status
     *
     * @return bool
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->getAuthIdentifier());
    }

    public function hasVerified()
    {
        $this->verified = true;
        $this->verify_token = null;
        $this->save();
    }

    function path()
    {
        return 'users';
    }

    function lang()
    {
        return 'user';
    }
}

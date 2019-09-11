<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Online\OnlineChecker;
use QuadStudio\Rbac\Concerns\RbacUsers;
use QuadStudio\Service\Site\Concerns\Schedulable;
use QuadStudio\Service\Site\Contracts\Addressable;

class User extends Authenticatable implements Addressable
{
    use Notifiable, RbacUsers, OnlineChecker, Schedulable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'dealer',
        'display', 'active', 'image_id', 'only_ferroli', 'verified',
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

    protected $dates = [
        'logged_at'
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
            'path' => 'logo/default.png',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function unsubscribe()
    {
        return $this->hasOne(Unsubscribe::class, 'email', 'email');
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
     * Авторизации
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function authorizations()
    {
        return $this->hasMany(Authorization::class);
    }

    /**
     * Подтвержденные авторизации
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function authorization_accepts()
    {
        return $this->hasMany(AuthorizationAccept::class);
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

    /**
     * @return Collection
     */
    public function warehouses()
    {

        $result = collect([]);


        if ($this->hasRole(config('site.warehouse_check', []), false) || $this->getAttribute('only_ferroli') == 1) {

            $result = $result->merge(User::query()
                ->find(config('site.receiver_id'))
                ->addresses()
                ->has('product_group_types')
                ->where('type_id', 6)
                ->get());
        }

        if($this->region && $this->getAttribute('only_ferroli') == 0){
	        $result = $result->merge(
		        $this->region->warehouses()
			        ->where('addresses.addressable_type', 'users')
			        ->where('addresses.addressable_id', '!=', auth()->id())
			        ->has('product_group_types')
			        ->get()
			        ->filter(function ($address) {
				        return $address->addressable->hasRole(config('site.warehouse_check', []), false);
			        })
	        );
        }

        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function mounters()
    {
        return Mounter::query()
            ->whereHas('userAddress', function ($address) {
                $address
                    ->where('addressable_type', '=', 'users')
                    ->where('addressable_id', '=', $this->getAuthIdentifier());
            });//->orderBy('created_at', 'DESC')
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function contracts()
    {
        return Contract::query()->whereHas('contragent', function ($contragent) {
            $contragent->where('user_id', '=', $this->getAuthIdentifier());
        });
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
     * Склады дистрибьюторов
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function storehouses()
    {
        return $this->hasMany(Storehouse::class);
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
     * Отчеты по монтажу
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class);
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

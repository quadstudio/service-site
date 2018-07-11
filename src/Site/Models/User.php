<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use QuadStudio\Online\OnlineChecker;
use QuadStudio\Rbac\Traits\Models\RbacUserTrait;

class User extends Authenticatable
{
    use Notifiable, RbacUserTrait, OnlineChecker;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'sc', 'web',
        'display', 'price_type_id', 'active',
        'warehouse_id'
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
//        static::updated(function(User $user){
//            dd('Models\User');
//            if(is_null($user->guid) &&$user->hasRole('asc')){
//                event(new Authorized($user));
//            }
//        });
    }

    public function can_export()
    {
        return is_null($this->guid);
    }

    public function created_at()
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y H:i') : '';
    }

    public function logged_at()
    {
        //dd($this->logged_at);
        return !is_null($this->logged_at) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d H:i:s', $this->logged_at))->format('d.m.Y H:i') : '';
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
     * Адреса
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Сервисный центр
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Тип цены
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function price_type()
    {
        return $this->belongsTo(PriceType::class);
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
}

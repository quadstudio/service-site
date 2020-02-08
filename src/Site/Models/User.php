<?php

namespace QuadStudio\Service\Site\Models;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use QuadStudio\Online\OnlineChecker;
use QuadStudio\Rbac\Concerns\RbacUsers;
use QuadStudio\Service\Site\Concerns\Schedulable;
use QuadStudio\Service\Site\Contracts\Addressable;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Services\Digift;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;
use \Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends Authenticatable implements Addressable, Messagable
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
		'warehouse_id', 'currency_id', 'region_id', 'type_id',
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
		'logged_at',
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
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function type()
	{
		return $this->belongsTo(ContragentType::class, 'type_id');
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


		if ($this->getAttribute('only_ferroli') == 1) {

			$result = $result->merge(User::query()
				->find(config('site.receiver_id'))
				->addresses()
				->has('product_group_types')
				->where('type_id', 6)
				->get());
		}

		if ($this->region && $this->getAttribute('only_ferroli') == 0) {
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

	public function orders_last_3()
	{
		return $this->hasMany(Order::class)->orderBy('created_at', 'DESC')->Limit(3);
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
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function certificates()
	{
		return $this->hasManyThrough(Certificate::class, Engineer::class);
	}

	public function mountingCertificates()
	{
		return $this->certificates()->where('type_id', 2);
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
		return $this->hasMany(Message::class, 'user_id')->where('personal', 0);
	}

	/**
	 * Полученные сообщения
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function inbox()
	{
		return $this->hasMany(Message::class, 'receiver_id')->where('personal', 0);
	}

	/**
	 * Сообщения
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function messages():MorphMany
	{
		return $this->morphMany(Message::class, 'messagable');
	}

	/**
	 * Бонусы Digift
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function digiftBonuses()
	{
		return $this->hasMany(DigiftBonus::class);
	}

	/**
	 * @throws DigiftException
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function makeDigiftBonus()
	{
		$this->makeDigiftUser();
	}

	/**
	 * @throws DigiftException
	 * @throws GuzzleException
	 */
	public function makeDigiftUser()
	{
		dd($this->getDigiftUserData());
		if ($this->digiftUser()->doesntExist()) {
			$response = (new Digift())->createParticipant($digiftUserData = $this->getDigiftUserData())->request();
			if ($response->getStatusCode() === Response::HTTP_OK) {
				$body = json_decode($response->getBody(), true);
				if ($body['code'] == 0) {
					$this->digiftUser()->create([
						'id' => $digiftUserData['id'],
						'accessToken' => $body['result']['accessToken'],
						'tokenExpired' => $body['result']['tokenExpired'],
						'fullUrlToRedirect' => $body['result']['fullUrlToRedirect'],
					]);
				} else {
					throw new DigiftException($body['message']);
				}
			}
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function digiftUser()
	{
		return $this->hasOne(DigiftUser::class, 'user_id');
	}

	public function getDigiftUserData()
	{
		$id = Str::uuid()->toString();

		$contacts = $this->contacts()->where('type_id', 1);
		if ($contacts->exists()) {
			/** @var HasMany $phones */
			$phones = $contacts->first()->phones();
			if ($phones->exists()) {
				$phone = $phones->first();
				list($lastName, $firstName, $middleName,) = explode(' ', $this->getAttribute('name'));

				return [
					'id' => $id,
					'email' => $this->getAttribute('email'),
					'phone' => preg_replace('/\D/', '', $phone->country->phone . $phone->number),
					'balance' => 0,
					'lastName' => $lastName,
					'firstName' => $firstName,
					'middleName' => $middleName,
				];
			}
		}

		return [];

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

	/**
	 * @return string
	 */
	function messageSubject()
	{
		return trans('site::message.message');
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageRoute()
	{
		return route((auth()->user()->admin == 1 ? 'messages.index' : 'admin.users.show'), $this);
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageMailRoute()
	{
		return route((auth()->user()->admin == 1 ? 'messages.index' : 'admin.users.show'), $this);
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageStoreRoute()
	{
		return route('admin.users.message', $this);
	}

	/** @return User */
	function messageReceiver()
	{
		return $this->id == auth()->user()->getAuthIdentifier()
			? User::query()->findOrFail(config('site.receiver_id'))
			: $this;
	}
}

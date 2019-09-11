<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Concerns\AttachAuthorizationTypes;

class Authorization extends Model implements Messagable
{

	use AttachAuthorizationTypes;

	/**
	 * @var string
	 */
	protected $table = 'authorizations';

	protected $fillable = [
		'role_id', 'status_id',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function status()
	{
		return $this->belongsTo(AuthorizationStatus::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function statuses()
	{
		if ($this->getAttribute('status_id') != 1) {
			return collect([]);
		}

		return AuthorizationStatus::query()->whereNotNull('button')->get();
	}

	public function makeAccepts()
	{

		if ($this->types()->exists()) {
			if ($this->getAttribute('status_id') == 2) {
				$accepts = [];
				foreach ($this->types()->pluck('id') as $type_id) {
					$accepts[] = new AuthorizationAccept([
						'type_id' => $type_id,
						'role_id' => $this->getAttribute('role_id'),
					]);
				}
				$this->user->authorization_accepts()->saveMany($accepts);

				if (!$this->user->roles->contains('id', $this->getAttribute('role_id'))) {
					$this->user->attachRole($this->getAttribute('role_id'));
				}
			} else {
				AuthorizationAccept::query()
					->where('user_id', $this->getAttribute('user_id'))
					->where('role_id', $this->getAttribute('role_id'))
					->whereIn('type_id', $this->types()->pluck('id')->toArray())
					->delete()
				;
			}
		}
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	/**
	 * Сообщения
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function messages()
	{
		return $this->morphMany(Message::class, 'messagable');
	}

	/**
	 * @return string
	 */
	function messageSubject()
	{
		return trans('site::authorization.header.authorization') . ' ' . $this->getAttribute('id');
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageRoute()
	{
		return route((auth()->user()->admin == 1 ? 'admin.' : '') . 'authorizations.show', $this);
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageMailRoute()
	{
		return route((auth()->user()->admin == 1 ? '' : 'admin.') . 'authorizations.show', $this);
	}

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function messageStoreRoute()
	{
		return route('authorizations.message', $this);
	}

	/** @return User */
	/** @return User */
	function messageReceiver()
	{
		return $this->user->id == auth()->user()->getAuthIdentifier()
			? User::query()->findOrFail(config('site.receiver_id'))
			: $this->user;
	}
}

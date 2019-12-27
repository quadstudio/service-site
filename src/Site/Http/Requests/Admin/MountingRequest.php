<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Validator;
use QuadStudio\Service\Site\Events\Digift\BonusCreateEvent;
use QuadStudio\Service\Site\Events\MountingStatusChangeEvent;
use QuadStudio\Service\Site\Http\Requests\Api\DigiftServiceRequest;
use QuadStudio\Service\Site\Models\DigiftUser;
use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\User;

class MountingRequest extends FormRequest
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{

		switch ($this->method()) {

			case 'PUT':
			case 'PATCH':
				{
					return [
						'mounting.status_id' => 'required|exists:mounting_statuses,id',
						'mounting.social_enabled' => 'required|boolean',
					];
				}
			default:
				return [];
		}
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{
		return [
			'mounting.status_id' => trans('site::mounting.status_id'),
			'mounting.social_enabled' => trans('site::mounting.social_enabled'),

		];
	}

	/**
	 * @param Mounting $mounting
	 *
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \QuadStudio\Service\Site\Exceptions\Digift\DigiftException
	 */
	public function update(Mounting $mounting)
	{
		$mounting->fill($this->input('mounting'));
		$status_changed = $mounting->isDirty('status_id');

		//if ($mounting->save()) {
			if ($mounting->getAttribute('status_id') == 2) {
				/** @var User $user */
				$user = $mounting->user;
				$user->makeDigiftUser();
				$mounting->digiftBonus()->create([
					'user_id' => $user->digiftUser->id,
					'operationValue' => $mounting->total
				]);
				//event(new BonusCreateEvent($mounting));
			}
//			if ($status_changed) {
//				event(new MountingStatusChangeEvent($mounting));
//			}
		//}
	}
}

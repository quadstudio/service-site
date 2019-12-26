<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use QuadStudio\Service\Site\Models\Mounting;

class DigiftUserRequest extends FormRequest
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

			case 'POST':
				{
					return [
						'digift_user.accessToken' => 'required|string',
						'digift_user.tokenExpired' => 'required|isTimeStamp',
						'digift_user.fullUrlToRedirect' => 'required|string',
					];
				}

			default:
				return [];
		}
	}

	/**
	 * Get custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'digift_bonus.tokenExpired.isTimeStamp' => trans('site::digift_user.error.isTimeStamp'),
		];
	}

	/**
	 * Get custom attributes for validator errors.
	 *
	 * @return array
	 */
	public function attributes()
	{

		return [
			'digift_bonus.accessToken' => trans('site::digift_bonus.accessToken'),
			'digift_bonus.operationValue' => trans('site::digift_bonus.operationValue'),
			'digift_bonus.fullUrlToRedirect' => trans('site::digift_bonus.fullUrlToRedirect'),
		];
	}

	public function store_mounting(Mounting $mounting)
	{

	}
}

<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
						'order_item.weeks_delivery' => 'required|number|between:' . config('site.weeks_delivery.min') . ',' . config('site.weeks_delivery.max'),
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
			'order_item.weeks_deliver' => trans('site::order_item.weeks_deliver'),
		];
	}

}

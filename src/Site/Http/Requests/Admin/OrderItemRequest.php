<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

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
			case 'PATCH':
				{
					return [
						'order_item.*.weeks_delivery' => 'sometimes|required|numeric|between:' . config('site.weeks_delivery.min') . ',' . config('site.weeks_delivery.max'),
						'order_item.*.price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
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
			'order_item.*.weeks_delivery' => trans('site::order_item.weeks_delivery'),
			'order_item.*.price' => trans('site::order_item.price'),
		];
	}

}

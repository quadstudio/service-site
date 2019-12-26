<?php

namespace QuadStudio\Service\Site\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use QuadStudio\Service\Site\Events\Digift\ExpenseApiExceptionEvent;
use QuadStudio\Service\Site\Models\DigiftExpense;
use QuadStudio\Service\Site\Rules\DigiftUserBlockedRule;

class DigiftRequest extends FormRequest
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
						'userDigiftId' => [
							'required',
							'string',
							'exists:digift_users,id',
							new DigiftUserBlockedRule(),
						],
						'digiftOperationId' => 'required|string|unique:digift_expenses,id',
						'operationValue' => 'required|regex:/^[1-9]\d*$/',
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
			'userDigiftId.required' => trans('site::digift_expense.error.data_not_valid'),
			'userDigiftId.exists' => trans('site::digift_expense.error.userDigiftId.exists'),
			'digiftOperationId.unique' => trans('site::digift_expense.error.digiftOperationId.unique'),
			'operationValue.required' => trans('site::digift_expense.error.data_not_valid'),
			'operationValue.regex' => trans('site::digift_expense.error.data_not_valid'),
		];
	}

	public function store()
	{
		DigiftExpense::query()->create([
			'id' => $this->input('digiftOperationId'),
			'user_id' => $this->input('userDigiftId'),
			'operationValue' => $this->input('operationValue'),

		]);
	}

	/**
	 * @param Validator $validator
	 */
	protected function failedValidation(Validator $validator)
	{
		$errors = (new ValidationException($validator))->errors();

		event(new ExpenseApiExceptionEvent($this->all(), $error = array_shift($errors)[0]));

		throw new HttpResponseException(
			response()->json($error, 200)
		);
	}
}

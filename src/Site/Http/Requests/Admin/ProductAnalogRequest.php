<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductAnalogRequest extends FormRequest
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
            case 'POST': {
                return [
                    'analogs'       => 'required|string',
                    'separator_row' => 'required|string',
                    'mirror'        => 'required|boolean',
                ];
            }
            case 'DELETE': {
                return [
                    'delete'        => 'required|array',
                    'mirror_delete' => 'sometimes|boolean',
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
            'delete.required' => trans('site::analog.error.delete.required'),
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
            'analogs'       => trans('site::analog.analogs'),
            'separator_row' => trans('site::messages.separator.row'),
            'mirror'        => trans('site::messages.mirror'),
        ];
    }
}

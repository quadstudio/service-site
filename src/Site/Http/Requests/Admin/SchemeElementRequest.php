<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SchemeElementRequest extends FormRequest
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
            case 'DELETE': {
                return [
                    'elements'         => 'required|array'
                ];
            }
            case 'POST': {
                return [
                    'elements'         => 'required|string',
                    'separator_row'    => 'required|string',
                    'separator_column' => 'required|string',
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
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'elements'      => trans('site::element.elements'),
            'separator_row' => trans('site::messages.separator.row'),
            'separator_column' => trans('site::messages.separator.column'),
        ];
    }
}

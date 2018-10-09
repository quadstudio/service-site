<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PartRequest extends FormRequest
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
            case 'PATCH': {
                return [
                    'count' => 'required|integer|min:1|max:4',
                    'cost'  => 'required|regex:/^\d*(\.\d{2})?$/',
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
            'count' => trans('site::part.count'),
            'cost'  => trans('site::part.cost'),
        ];
    }
}

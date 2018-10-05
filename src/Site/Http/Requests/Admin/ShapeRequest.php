<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShapeRequest extends FormRequest
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
                    'element_id' => 'required|exists:elements,id',
                    'shape'      => [
                        'required',
                        Rule::in(['rect', 'circle', 'poly']),
                    ],
                    'coords'     => 'required|string',
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
            'element_id' => trans('site::shape.element_id'),
            'shape'      => trans('site::shape.shape'),
            'coords'     => trans('site::shape.coords'),
        ];
    }
}

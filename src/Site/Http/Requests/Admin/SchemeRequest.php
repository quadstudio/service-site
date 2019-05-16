<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SchemeRequest extends FormRequest
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
            case 'POST': {
                return [
                    'scheme.block_id'     => 'required|exists:blocks,id',
                    'scheme.image_id'     => 'required|exists:images,id',
                    'scheme.datasheet_id' => 'required|exists:datasheets,id',
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
            'scheme.image_id.required' => trans('site::scheme.error.image_id.required'),
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
            'scheme.block_id'     => trans('site::scheme.block_id'),
            'scheme.image_id'     => trans('site::scheme.image_id'),
            'scheme.datasheet_id' => trans('site::scheme.datasheet_id'),
        ];
    }
}

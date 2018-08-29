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
        $prefix = env('DB_PREFIX', '');
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'PUT':
            case 'PATCH':
            case 'POST': {
                return [
                    'block_id'     => 'required|exists:' . $prefix . 'blocks,id',
                    'image_id'     => 'required|exists:' . $prefix . 'images,id',
                    'datasheet_id' => 'required|exists:' . $prefix . 'datasheets,id',
                    'equipments'   => 'required|array|min:1',
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
            'equipments.required' => trans('site::scheme.error.equipments.required'),
            'image_id.required' => trans('site::scheme.error.image_id.required'),
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
            'block_id'     => trans('site::scheme.block_id'),
            'image_id'     => trans('site::scheme.image_id'),
            'datasheet_id' => trans('site::scheme.datasheet_id'),
            'equipments'   => trans('site::scheme.equipments'),
        ];
    }
}

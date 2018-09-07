<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DatasheetRequest extends FormRequest
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
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'PUT':
            case 'PATCH':
            case 'POST': {
                return [
                    'name'      => 'required|string|max:255',
                    'active'    => 'required|boolean',
                    'file_id'   => 'required|exists:files,id',
                    'type_id'   => 'required|exists:file_types,id',
                    'date_from' => 'nullable|date',
                    'date_to'   => 'nullable|date',
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
            'name'    => trans('site::datasheet.name'),
            'active'  => trans('site::datasheet.active'),
            'file_id' => trans('site::datasheet.file_id'),
            'type_id' => trans('site::datasheet.type_id'),
        ];
    }
}

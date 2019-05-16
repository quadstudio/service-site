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
            case 'PUT':
            case 'PATCH':
            case 'POST': {
                return [
                    'datasheet.name'      => 'required|string|max:255',
                    'datasheet.file_id'   => 'required|exists:files,id',
                    'datasheet.type_id'   => 'required|exists:file_types,id',
                    'datasheet.date_from' => 'nullable|date_format:"d.m.Y"',
                    'datasheet.date_to'   => 'nullable|date_format:"d.m.Y"',
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
            'datasheet.name'      => trans('site::datasheet.name'),
            'datasheet.file_id'   => trans('site::datasheet.file_id'),
            'datasheet.type_id'   => trans('site::datasheet.type_id'),
            'datasheet.date_from' => trans('site::datasheet.date_from'),
            'datasheet.date_to'   => trans('site::datasheet.date_to'),
        ];
    }
}

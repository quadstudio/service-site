<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DatasheetProductRequest extends FormRequest
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
                    'delete' => 'required|exists:products,id',
                ];
            }
            case 'POST': {
                return [
                    'products'      => 'required|string',
                    'separator_row' => 'required|string',
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
            'products'      => trans('site::datasheet.header.products'),
            'delete'      => trans('site::datasheet.header.products'),
            'separator_row' => trans('site::messages.separator.row'),
        ];
    }
}

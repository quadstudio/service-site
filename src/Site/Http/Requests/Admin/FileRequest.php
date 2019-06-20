<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
                    'path'    => 'required|mimes:' . config('site.'.$this->input('storage').'.mime', 'jpg,jpeg,png,pdf') . '|max:' . config('site.files.size', 5000000),
                    'type_id' => 'required',
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
            'path.mimes'  => trans('site::file.error.path'),
            'path.max'  => trans('site::file.error.max'),
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
            'path'    => trans('site::file.path'),
            'type_id' => trans('site::file.type_id'),
        ];
    }
}

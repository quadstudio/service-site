<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use QuadStudio\Service\Site\Rules\CertificateLoad;

class CertificateRequest extends FormRequest
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
                    'path' => [
                        'required',
                        'mimes:xls,xlsx',
                        'max:' . config('site.files.size', 8092),
                        new CertificateLoad
                    ],
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
            'certificates'  => trans('site::certificate.certificates'),
            'separator_row' => trans('site::messages.separator.row'),
        ];
    }
}

<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use QuadStudio\Service\Site\Rules\OrderLoad;

class OrderLoadRequest extends FormRequest
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
                        new OrderLoad
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
        return [
            'path.required' => trans('site::order.error.load.empty'),
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
            'products'   => trans('site::messages.products'),
            'comments'   => trans('site::messages.comments'),
            'address_id' => trans('site::order.address_id'),
        ];
    }
}

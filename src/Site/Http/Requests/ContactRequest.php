<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            case 'POST': {
                $rules = [
                    'contact.name'     => 'required|string|max:255',
                    'contact.position' => 'max:255',
                    'contact.type_id'  => 'required|exists:contact_types,id',
                    //
                    'phone.country_id' => 'required|exists:countries,id',

                    'phone.number'           => array(
                        'required',
                        'numeric',
                        function ($attribute, $value, $fail) {

                            if ($this->input('phone.country_id') == 643 && strlen($value) != 10) {
                                return $fail(trans('site::phone.error.length_10'));
                            }
                            if ($this->input('phone.country_id') == 112 && strlen($value) != 9) {
                                return $fail(trans('site::phone.error.length_9'));
                            }
                        }
                    ),
                    'phone.extra'      => 'max:20',
                ];

                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'contact.name'     => 'required|string|max:255',
                    'contact.position' => 'max:255',
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
            'contact.name'     => trans('site::contact.name'),
            'contact.position' => trans('site::contact.position'),
            'contact.type_id'  => trans('site::contact.type_id'),
            //
            //
            'phone.country_id'   => trans('site::phone.country_id'),
            'phone.number'       => trans('site::phone.number'),
            'phone.extra'        => trans('site::phone.extra'),
        ];
    }
}

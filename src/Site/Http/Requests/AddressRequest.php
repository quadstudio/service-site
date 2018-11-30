<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
                    'address.type_id'      => 'required|exists:address_types,id',
                    'address.name'         => 'required_if:address.type_id,2|max:255',
                    'address.country_id'   => 'required|exists:countries,id',
                    'address.region_id'    => 'sometimes|exists:regions,id',
                    'address.locality'     => 'required|string|max:255',
                    'address.street'       => 'sometimes|max:255',
                    'address.building'     => 'required|string|max:255',
                    'address.apartment'    => 'sometimes|max:255',
                    'address.emailaddress' => 'sometimes|email',
                    //
                    'phone.country_id'     => 'required|exists:countries,id',
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
                    'phone.extra'          => 'max:20',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'address.type_id'      => 'required|exists:address_types,id',
                    'address.name'         => 'required_if:address.type_id,2|max:255',
                    'address.country_id'   => 'required|exists:countries,id',
                    'address.region_id'    => 'sometimes|exists:regions,id',
                    'address.locality'     => 'required|string|max:255',
                    'address.street'       => 'sometimes|max:255',
                    'address.building'     => 'required|string|max:255',
                    'address.apartment'    => 'sometimes|max:255',
                    'address.sort_order'   => 'numeric|min:0|max:200',
                    'address.emailaddress' => 'sometimes|email',
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
            //
            'address.name'       => trans('site::address.name'),
            'address.country_id' => trans('site::address.country_id'),
            'address.region_id'  => trans('site::address.region_id'),
            'address.locality'   => trans('site::address.locality'),
            'address.street'     => trans('site::address.street'),
            'address.building'   => trans('site::address.building'),
            'address.apartment'  => trans('site::address.apartment'),
            'address.sort_order' => trans('site::address.sort_order'),
            //
            'phone.country_id'   => trans('site::phone.country_id'),
            'phone.number'       => trans('site::phone.number'),
            'phone.extra'        => trans('site::phone.extra'),
        ];
    }
}

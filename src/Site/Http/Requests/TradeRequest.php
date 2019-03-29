<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TradeRequest extends FormRequest
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
                    'trade.name'       => 'required|string|max:255',
                    'trade.country_id' => 'required|exists:countries,id',
                    'trade.phone'      => 'required|string|size:' . config('site.phone.maxlength'),
                    'trade.address'    => 'sometimes|nullable|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'trade.country_id' => 'required|exists:countries,id',
                    'trade.phone'      => 'required|string|size:' . config('site.phone.maxlength'),
                    'trade.address'    => 'sometimes|nullable|max:255',
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
            'trade.name'       => trans('site::trade.name'),
            'trade.country_id' => trans('site::trade.country_id'),
            'trade.phone'      => trans('site::trade.phone'),
            'trade.address'    => trans('site::trade.address'),
        ];
    }
}

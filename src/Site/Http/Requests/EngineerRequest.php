<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EngineerRequest extends FormRequest
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
                    'engineer.name'       => 'required|string|max:255',
                    'engineer.country_id' => 'required|exists:countries,id',
                    'engineer.phone'      => 'required|string|size:'.config('site.phone.maxlength'),
                    'engineer.address'    => 'sometimes|nullable|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'engineer.country_id' => 'required|exists:countries,id',
                    'engineer.phone'      => 'required|string|size:'.config('site.phone.maxlength'),
                    'engineer.address'    => 'sometimes|nullable|max:255',
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
            'engineer.name'       => trans('site::engineer.name'),
            'engineer.country_id' => trans('site::engineer.country_id'),
            'engineer.phone'      => trans('site::engineer.phone'),
            'engineer.address'    => trans('site::engineer.address'),
        ];
    }
}

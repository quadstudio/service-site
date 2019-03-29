<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaunchRequest extends FormRequest
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
                    'launch.name'       => 'required|string|max:255',
                    'launch.country_id' => 'required|exists:countries,id',
                    'launch.phone'      => 'required|string|size:' . config('site.phone.maxlength'),
                    'launch.address'    => 'sometimes|nullable|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'launch.country_id' => 'required|exists:countries,id',
                    'launch.phone'      => 'required|string|size:' . config('site.phone.maxlength'),
                    'launch.address'    => 'sometimes|nullable|max:255',
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
            'launch.name'       => trans('site::launch.name'),
            'launch.country_id' => trans('site::launch.country_id'),
            'launch.phone'      => trans('site::launch.phone'),
            'launch.address'    => trans('site::launch.address'),
        ];
    }
}

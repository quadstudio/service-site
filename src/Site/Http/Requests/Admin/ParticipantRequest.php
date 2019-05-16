<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
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
                    'participant.name'         => 'required|string|max:100',
                    'participant.headposition' => 'required|string|max:100',
                    'participant.email'        => 'nullable|email|max:50',
                    'participant.country_id'   => 'required|exists:countries,id',
                    'participant.phone'        => 'sometimes|nullable|size:' . config('site.phone.maxlength'),
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
            'participant.name'         => trans('site::participant.organization'),
            'participant.headposition' => trans('site::participant.headposition'),
            'participant.country_id'   => trans('site::participant.country_id'),
            'participant.phone'        => trans('site::participant.phone'),
            'participant.email'        => trans('site::participant.email'),

        ];
    }
}

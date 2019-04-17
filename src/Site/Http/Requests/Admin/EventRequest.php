<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
                    'event.status_id'  => 'required|exists:event_statuses,id',
                    'event.type_id'    => 'required|exists:event_types,id',
                    'event.region_id'  => 'required|exists:regions,id',
                    'event.city'       => 'required|string|max:100',
                    'event.title'      => 'required|string|max:64',
                    'event.annotation' => 'required|string|max:255',
                    'event.date_from'  => 'required|date',
                    'event.date_to'    => 'required|date|after_or_equal:date_from',
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
            'event.date_to.after_or_equal' => trans('site::event.error.date_to.after_or_equal'),
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
            'event.status_id'  => trans('site::event.status_id'),
            'event.type_id'    => trans('site::event.type_id'),
            'event.region_id'  => trans('site::event.region_id'),
            'event.title'      => trans('site::event.title'),
            'event.city'       => trans('site::event.city'),
            'event.annotation' => trans('site::event.annotation'),
            'event.date_from'  => trans('site::event.date_from'),
            'event.date_to'    => trans('site::event.date_to'),
        ];
    }
}

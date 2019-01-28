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
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'PUT':
            case 'PATCH':
            case 'POST': {
                return [
                    'status_id'  => 'required|exists:event_statuses,id',
                    'type_id'    => 'required|exists:event_types,id',
                    'region_id'  => 'required|exists:regions,id',
                    'city'       => 'required|string|max:100',
                    'title'      => 'required|string|max:64',
                    'annotation' => 'required|string|max:255',
                    'date_from'  => 'required|date',
                    'date_to'    => 'required|date|after_or_equal:date_from',
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
            'date_to.after_or_equal' => trans('site::event.error.date_to.after_or_equal'),
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
            'status_id'  => trans('site::event.status_id'),
            'type_id'    => trans('site::event.type_id'),
            'region_id'  => trans('site::event.region_id'),
            'title'      => trans('site::event.title'),
            'city'       => trans('site::event.city'),
            'annotation' => trans('site::event.annotation'),
            'date_from'  => trans('site::event.date_from'),
            'date_to'    => trans('site::event.date_to'),
        ];
    }
}

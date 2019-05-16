<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
                    'announcement.title'      => 'required|string|max:64',
                    'announcement.annotation' => 'required|string|max:255',
                    'announcement.date'       => 'required|date_format:"d.m.Y',
                    'announcement.image_id'   => 'sometimes|nullable|exists:images,id',
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
            'announcement.title'       => trans('site::news.title'),
            'announcement.annotation'  => trans('site::news.annotation'),
            'announcement.description' => trans('site::news.description'),
            'announcement.date'        => trans('site::news.date'),
            'announcement.image_id'    => trans('site::news.image_id'),
        ];
    }
}

<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
                    'title'       => 'required|string|max:64',
                    'annotation'  => 'required|string|max:255',
                    'published'   => 'required|boolean',
                    'date'        => 'required|date_format:"Y-m-d"',
                    'image_id'    => 'sometimes|exists:images,id',
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
            'title'       => trans('site::news.title'),
            'annotation'  => trans('site::news.annotation'),
            'description' => trans('site::news.description'),
            'date'        => trans('site::news.date'),
            'published'   => trans('site::news.published'),
            'image_id'    => trans('site::news.image_id'),
        ];
    }
}

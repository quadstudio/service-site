<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EngineerRequest extends FormRequest
{
    /**
     * @var string
     */
    protected $table;

    /**
     * PermissionRequest constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->table = env("DB_PREFIX", "") . 'engineers';
    }

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
                return [
                    'name'       => 'required|string|max:255',
                    'country_id' => 'required',
                    'phone'      => 'required|numeric|digits:10',
                    'address'    => 'required|string|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'country_id' => 'required',
                    'phone'      => 'required|numeric|digits:10',
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
            'name'       => trans('site::engineer.name'),
            'address'    => trans('site::engineer.address'),
            'country_id' => trans('site::engineer.country_id'),
            'phone'      => trans('site::engineer.phone'),
        ];
    }
}

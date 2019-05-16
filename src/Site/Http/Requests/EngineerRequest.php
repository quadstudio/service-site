<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use QuadStudio\Service\Site\Models\Certificate;
use QuadStudio\Service\Site\Models\CertificateType;

class EngineerRequest extends FormRequest
{

    private $_certificate_types;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->_certificate_types = CertificateType::query()->pluck('name', 'id')->toArray();
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
            case 'POST': {
                $rules = [
                    'engineer.name'       => 'required|string|max:255',
                    'engineer.country_id' => 'required|exists:countries,id',
                    'engineer.phone'      => 'required|string|size:' . config('site.phone.maxlength'),
                    'engineer.address'    => 'sometimes|nullable|max:255',
                ];
                foreach ($this->_certificate_types as $key => $value) {
                    $rules['certificate.' . $key] = [
                        'sometimes',
                        'nullable',
                        'exists:certificates,id',
                        function ($attribute, $value, $fail) use ($key) {

                            if (Certificate::query()
                                ->where('id', $value)
                                ->where(function ($query) use ($key) {
                                    $query
                                        ->orWhere('type_id', '!=', $key)
                                        ->orWhereNotNull('engineer_id');
                                })
                                ->exists()
                            ) {
                                return $fail(__('site::certificate.error.id'));
                            }
                        }
                    ];
                }

                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                $rules = [
                    'engineer.country_id' => 'required|exists:countries,id',
                    'engineer.phone'      => 'required|string|size:' . config('site.phone.maxlength'),
                    'engineer.address'    => 'sometimes|nullable|max:255',
                ];

            foreach ($this->_certificate_types as $key => $value) {
                $rules['certificate.' . $key] = [
                    'sometimes',
                    'nullable',
                    'exists:certificates,id',
                    function ($attribute, $value, $fail) use ($key) {
                        if (Certificate::query()
                            ->where('id', $value)
                            ->where(function ($query) use ($key) {
                                $query
                                    ->orWhere('type_id', '!=', $key)
                                    ->orWhere(function($query){
                                        $query
                                            ->whereNotNull('engineer_id')
                                            ->where('engineer_id' , '!=', $this->route('engineer')->id)
                                        ;
                                    });
                            })
                            ->exists()
                        ) {
                            return $fail(__('site::certificate.error.id'));
                        }
                    }
                ];
            }

                return $rules;
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
        $messages = [];
        foreach (array_keys($this->_certificate_types) as $key) {
            $messages['certificate.' . $key . '.exists'] = __('site::certificate.error.id');
        }

        return $messages;
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

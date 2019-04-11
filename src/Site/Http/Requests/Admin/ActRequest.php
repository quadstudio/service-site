<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ActRequest extends FormRequest
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
                    'repair' => 'required|array|min:1',
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
            'repair.required' => trans('site::act.error.require')
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
            'repair'          => trans('site::repair.contragent_id'),
            'client'          => trans('site::repair.client'),
            'country_id'      => trans('site::repair.country_id'),
            'address'         => trans('site::repair.address'),
            'phone_primary'   => trans('site::repair.phone_primary'),
            'phone_secondary' => trans('site::repair.phone_secondary'),
            'trade_id'        => trans('site::repair.trade_id'),
            'date_trade'      => trans('site::repair.date_trade'),
            'launch_id'       => trans('site::repair.launch_id'),
            'date_launch'     => trans('site::repair.date_launch'),
            'engineer_id'     => trans('site::repair.engineer_id'),
            'date_call'       => trans('site::repair.date_call'),
            'reason_call'     => trans('site::repair.reason_call'),
            'diagnostics'     => trans('site::repair.diagnostics'),
            'works'           => trans('site::repair.works'),
            'date_repair'     => trans('site::repair.date_repair'),
            'allow_work'      => trans('site::repair.allow_work'),
            'allow_road'      => trans('site::repair.allow_road'),
            'allow_parts'     => trans('site::repair.allow_parts'),
            'file.1'          => trans('site::repair.file_1'),
            'file.2'          => trans('site::repair.file_2'),
            'file.3'          => trans('site::repair.file_3'),
        ];
    }
}

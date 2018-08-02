<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use QuadStudio\Service\Site\Rules\ValidSerial;

class RepairRequest extends FormRequest
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
        $prefix = env('DB_PREFIX', '');
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [

                    'serial_id'       => [
                        'required',
                        'string',
                        new ValidSerial()
                    ],
                    'number'          => 'required|string|max:10',
                    'warranty_number' => 'required|string|max:10',
                    'warranty_period' => 'required|numeric|digits:2',
                    'client'          => 'required|string|max:255',
                    'country_id'      => 'required|exists:' . $prefix . 'countries,id',
                    'address'         => 'required|string|max:255',
                    'phone_primary'   => 'required|numeric|digits:10',
                    //'phone_secondary' => 'required|numeric|digits:10',
                    'trade_id'        => [
                        'required',
                        'exists:' . $prefix . 'trades,id',
                        Rule::exists($prefix . 'trades', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'trades.user_id', $this->user()->id);
                        }),
                    ],
                    'date_trade'      => 'required|date_format:"Y-m-d"',
                    'launch_id'       => [
                        'required',
                        'exists:' . $prefix . 'launches,id',
                        Rule::exists($prefix . 'launches', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'launches.user_id', $this->user()->id);
                        }),
                    ],
                    'date_launch'     => 'required|date_format:"Y-m-d"',
                    'engineer_id'     => [
                        'required',
                        'exists:' . $prefix . 'engineers,id',
                        Rule::exists($prefix . 'engineers', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'engineers.user_id', $this->user()->id);
                        }),
                    ],
                    'date_call'       => 'required|date_format:"Y-m-d"',
                    'reason_call'     => 'required|string',
                    'diagnostics'     => 'required|string',
                    'works'           => 'required|string',
                    'date_repair'     => 'required|date_format:"Y-m-d"',
                    'file.1'          => 'required|array',
                    'file.2'          => 'required|array',

                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [

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
            'serial_id'       => trans('site::repair.serial_id'),
            'number'          => trans('site::repair.number'),
            'warranty_number' => trans('site::repair.warranty_number'),
            'warranty_period' => trans('site::repair.warranty_period'),
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
            'file.1'          => trans('site::repair.file_1'),
            'file.2'          => trans('site::repair.file_2'),
            'file.3'          => trans('site::repair.file_3'),
        ];
    }
}

<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                    'contragent_id' => [
                        'required',
                        'exists:' . $prefix . 'contragents,id',
                        Rule::exists($prefix . 'contragents', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'contragents.user_id', $this->user()->id);
                        }),
                    ],
                    'product_id'    => 'required|exists:' . $prefix . 'products,id',
                    'client'        => 'required|string|max:255',
                    'country_id'    => 'required|exists:' . $prefix . 'countries,id',
                    'address'       => 'required|string|max:255',
                    'phone_primary' => 'required|numeric|digits:10',
                    'trade_id'      => [
                        'required',
                        'exists:' . $prefix . 'trades,id',
                        Rule::exists($prefix . 'trades', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'trades.user_id', $this->user()->id);
                        }),
                    ],
                    'date_trade'    => 'required|date_format:"Y-m-d"',
                    'launch_id'     => [
                        'required',
                        'exists:' . $prefix . 'launches,id',
                        Rule::exists($prefix . 'launches', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'launches.user_id', $this->user()->id);
                        }),
                    ],
                    'date_launch'   => 'required|date_format:"Y-m-d"',
                    'engineer_id'   => [
                        'required',
                        'exists:' . $prefix . 'engineers,id',
                        Rule::exists($prefix . 'engineers', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'engineers.user_id', $this->user()->id);
                        }),
                    ],
                    'date_call'     => 'required|date_format:"Y-m-d"',
                    'reason_call'   => 'required|string',
                    'diagnostics'   => 'required|string',
                    'works'         => 'required|string',
                    'date_repair'   => 'required|date_format:"Y-m-d"',
                    'allow_work'    => 'required|boolean',
                    'allow_road'    => 'required|boolean',
                    'allow_parts'   => 'required|boolean',
                    'file.1'        => 'required|array',
                    'file.2'        => 'required|array',

                ];
            }
            case 'PUT':
            case 'PATCH': {
                $fails = $this->route('repair')->fails;
                $rules = collect([]);
                if ($fails->contains('field', 'contragent_id')) {
                    $rules->put('contragent_id', [
                        'required',
                        'exists:' . $prefix . 'contragents,id',
                        Rule::exists($prefix . 'contragents', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'contragents.user_id', $this->user()->id);
                        }),
                    ]);
                }
                if ($fails->contains('field', 'country_id')) {
                    $rules->put('country_id', 'required|exists:' . $prefix . 'countries,id');
                }
                if ($fails->contains('field', 'address')) {
                    $rules->put('address', 'required|string|max:255');
                }
                if ($fails->contains('field', 'phone_primary')) {
                    $rules->put('phone_primary', 'required|numeric|digits:10');
                }
                if ($fails->contains('field', 'trade_id')) {
                    $rules->put('trade_id', [
                        'required',
                        'exists:' . $prefix . 'trades,id',
                        Rule::exists($prefix . 'trades', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'trades.user_id', $this->user()->id);
                        }),
                    ]);
                }
                if ($fails->contains('field', 'date_trade')) {
                    $rules->put('date_trade', 'required|date_format:"Y-m-d"');
                }
                if ($fails->contains('field', 'launch_id')) {
                    $rules->put('launch_id', [
                        'required',
                        'exists:' . $prefix . 'launches,id',
                        Rule::exists($prefix . 'launches', 'id')->where(function ($query) use ($prefix) {
                            $query->where($prefix . 'launches.user_id', $this->user()->id);
                        }),
                    ]);
                }
                if ($fails->contains('field', 'date_launch')) {
                    $rules->put('date_launch', 'required|date_format:"Y-m-d"');
                }
                if ($fails->contains('field', 'date_call')) {
                    $rules->put('date_call', 'required|date_format:"Y-m-d"');
                }
                if ($fails->contains('field', 'reason_call')) {
                    $rules->put('reason_call', 'required|string');
                }
                if ($fails->contains('field', 'diagnostics')) {
                    $rules->put('diagnostics', 'required|string');
                }
                if ($fails->contains('field', 'works')) {
                    $rules->put('works', 'required|string');
                }
                if ($fails->contains('field', 'date_repair')) {
                    $rules->put('date_repair', 'required|date_format:"Y-m-d"');
                }
                if ($fails->contains('field', 'allow_work')) {
                    $rules->put('allow_work', 'required|boolean');
                }
                if ($fails->contains('field', 'allow_road')) {
                    $rules->put('allow_road', 'required|boolean');
                }
                if ($fails->contains('field', 'allow_parts')) {
                    $rules->put('allow_parts', 'required|boolean');
                }
                if ($fails->contains('field', 'file_1')) {
                    $rules->put('file.1', 'required|array');
                }
                if ($fails->contains('field', 'file_2')) {
                    $rules->put('file.2', 'required|array');
                }

                return $rules->toArray();
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
            'contragent_id'   => trans('site::repair.contragent_id'),
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

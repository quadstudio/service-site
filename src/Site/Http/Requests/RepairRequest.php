<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use QuadStudio\Service\Site\Models\FileType;

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
        $types = FileType::enabled()->required()->get();
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                $rules = [
                    'contragent_id' => [
                        'required',
                        'exists:contragents,id',
                        Rule::exists('contragents', 'id')->where(function ($query) {
                            $query->where('contragents.user_id', $this->user()->id);
                        }),
                    ],
                    'product_id'    => 'required|exists:products,id',
                    'client'        => 'required|string|max:255',
                    'country_id'    => 'required|exists:countries,id',
                    'address'       => 'required|string|max:255',
                    'phone_primary' => 'required|numeric|digits:10',
                    'trade_id'      => [
                        'required',
                        'exists:trades,id',
                        Rule::exists('trades', 'id')->where(function ($query) {
                            $query->where('trades.user_id', $this->user()->id);
                        }),
                    ],
                    'date_trade'    => 'required|date_format:"Y-m-d"',
                    'launch_id'     => [
                        'required',
                        'exists:launches,id',
                        Rule::exists('launches', 'id')->where(function ($query) {
                            $query->where('launches.user_id', $this->user()->id);
                        }),
                    ],
                    'date_launch'   => 'required|date_format:"Y-m-d"',
                    'engineer_id'   => [
                        'required',
                        'exists:engineers,id',
                        Rule::exists('engineers', 'id')->where(function ($query) {
                            $query->where('engineers.user_id', $this->user()->id);
                        }),
                    ],
                    'date_call'     => 'required|date_format:"Y-m-d"',
                    'reason_call'   => 'required|string',
                    'diagnostics'   => 'required|string',
                    'works'         => 'required|string',
                    'date_repair'   => 'required|date_format:"Y-m-d"',
                    'distance_id'   => 'required|exists:distances,id',
                    'difficulty_id' => 'required|exists:difficulties,id',

                ];
                foreach ($types as $type) {
                    $rules['file.' . $type->id] = 'required|array';
                }

                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                $fails = $this->route('repair')->fails;
                $rules = collect([]);
                if ($fails->contains('field', 'contragent_id')) {
                    $rules->put('contragent_id', [
                        'required',
                        'exists:contragents,id',
                        Rule::exists('contragents', 'id')->where(function ($query) {
                            $query->where('contragents.user_id', $this->user()->id);
                        }),
                    ]);
                }
                if ($fails->contains('field', 'country_id')) {
                    $rules->put('country_id', 'required|exists:countries,id');
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
                        'exists:trades,id',
                        Rule::exists('trades', 'id')->where(function ($query) {
                            $query->where('trades.user_id', $this->user()->id);
                        }),
                    ]);
                }
                if ($fails->contains('field', 'date_trade')) {
                    $rules->put('date_trade', 'required|date_format:"Y-m-d"');
                }
                if ($fails->contains('field', 'launch_id')) {
                    $rules->put('launch_id', [
                        'required',
                        'exists:launches,id',
                        Rule::exists('launches', 'id')->where(function ($query) {
                            $query->where('launches.user_id', $this->user()->id);
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
                if ($fails->contains('field', 'distance_id')) {
                    $rules->put('distance_id', 'required|exists:distances,id');
                }
                if ($fails->contains('field', 'difficulty_id')) {
                    $rules->put('difficulty_id', 'required|exists:difficulties,id');
                }
                foreach ($types as $type) {
                    if ($fails->contains('field', 'file_' . $type->id)) {
                        $rules->put('file.' . $type->id, 'required|array');
                    }
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
            'distance_id'     => trans('site::repair.distance_id'),
            'difficulty_id'   => trans('site::repair.difficulty_id'),
            'file.1'          => trans('site::repair.file_1'),
            'file.2'          => trans('site::repair.file_2'),
            'file.3'          => trans('site::repair.file_3'),
        ];
    }
}

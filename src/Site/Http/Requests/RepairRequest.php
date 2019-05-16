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
        $file_types = FileType::query()
            ->where('group_id', 1)
            ->where('enabled', 1)
            ->where('required', 1)
            ->get();
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                $rules = [
                    'repair.contragent_id' => [
                        'required',
                        'exists:contragents,id',
                        Rule::exists('contragents', 'id')->where(function ($query) {
                            $query->where('contragents.user_id', $this->user()->id);
                        }),
                    ],
                    'repair.product_id'    => 'required|exists:products,id',
                    'repair.client'        => 'required|string|max:255',
                    'repair.country_id'    => 'required|exists:countries,id',
                    'repair.address'       => 'required|string|max:255',
                    'repair.phone_primary' => 'required|string|size:'.config('site.phone.maxlength'),
                    'repair.trade_id'      => [
                        'required',
                        'exists:trades,id',
                        Rule::exists('trades', 'id')->where(function ($query) {
                            $query->where('trades.user_id', $this->user()->id);
                        }),
                    ],
                    'repair.date_trade'    => 'required|date_format:"d.m.Y"',
                    'repair.launch_id'     => [
                        'required',
                        'exists:launches,id',
                        Rule::exists('launches', 'id')->where(function ($query) {
                            $query->where('launches.user_id', $this->user()->id);
                        }),
                    ],
                    'repair.date_launch'   => 'required|date_format:"d.m.Y"',
                    'repair.engineer_id'   => [
                        'required',
                        'exists:engineers,id',
                        Rule::exists('engineers', 'id')->where(function ($query) {
                            $query->where('engineers.user_id', $this->user()->id);
                        }),
                    ],
                    'repair.date_call'     => 'required|date_format:"d.m.Y"',
                    'repair.reason_call'   => 'required|string',
                    'repair.diagnostics'   => 'required|string',
                    'repair.works'         => 'required|string',
                    'repair.date_repair'   => 'required|date_format:"d.m.Y"',
                    'repair.distance_id'   => 'required|exists:distances,id',
                    'repair.difficulty_id' => 'required|exists:difficulties,id',

                ];
                foreach ($file_types as $type) {
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
                    $rules->put('phone_primary', 'required|string|size:'.config('site.phone.maxlength'));
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
                foreach ($file_types as $type) {
                    $rules->put('file.' . $type->id, 'required|array');
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
        $attributes = [
            'repair.contragent_id'   => trans('site::repair.contragent_id'),
            'repair.client'          => trans('site::repair.client'),
            'repair.country_id'      => trans('site::repair.country_id'),
            'repair.address'         => trans('site::repair.address'),
            'repair.phone_primary'   => trans('site::repair.phone_primary'),
            'repair.phone_secondary' => trans('site::repair.phone_secondary'),
            'repair.trade_id'        => trans('site::repair.trade_id'),
            'repair.date_trade'      => trans('site::repair.date_trade'),
            'repair.launch_id'       => trans('site::repair.launch_id'),
            'repair.date_launch'     => trans('site::repair.date_launch'),
            'repair.engineer_id'     => trans('site::repair.engineer_id'),
            'repair.date_call'       => trans('site::repair.date_call'),
            'repair.reason_call'     => trans('site::repair.reason_call'),
            'repair.diagnostics'     => trans('site::repair.diagnostics'),
            'repair.works'           => trans('site::repair.works'),
            'repair.date_repair'     => trans('site::repair.date_repair'),
            'repair.distance_id'     => trans('site::repair.distance_id'),
            'repair.difficulty_id'   => trans('site::repair.difficulty_id'),
        ];

        $file_types = FileType::query()
            ->where('group_id', 1)
            ->where('enabled', 1)
            ->get();
        foreach ($file_types as $type) {
            $attributes['file.' . $type->id] = $type->name;
        }

        return $attributes;
    }
}

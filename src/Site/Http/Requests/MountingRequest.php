<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use QuadStudio\Service\Site\Models\FileType;

class MountingRequest extends FormRequest
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
            ->where('group_id', 4)
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
                    'mounting.source_id'    => 'required|exists:mounting_sources,id',
                    'mounting.source_other' => 'required_if:mounting.source_id,4|nullable|max:255',
                    'mounting.contragent_id' => [
                        'required',
                        'exists:contragents,id',
                        Rule::exists('contragents', 'id')->where(function ($query) {
                            /** @var \Illuminate\Database\Query\Builder $query */
                            $query->where('contragents.user_id', $this->user()->id);
                        }),
                    ],
                    'mounting.product_id'    => [
                        'required',
                        'exists:products,id',
//                        Rule::exists('products', 'id')->where(function ($query) {
//                            /** @var \Illuminate\Database\Query\Builder $query */
//                            $query->whereExists(function ($query) {
//                                /** @var \Illuminate\Database\Query\Builder $query */
//                                $query->select('mounting_bonuses.id')
//                                    ->from('mounting_bonuses')
//                                    ->whereRaw('mounting_bonuses.product_id = products.id');
//                            });
//                        }),
                    ],
                    'mounting.client'        => 'required|string|max:255',
                    'mounting.country_id'    => 'required|exists:countries,id',
                    'mounting.address'       => 'required|string|max:255',
                    'mounting.phone_primary' => 'required|string|size:14',
                    'mounting.trade_id'      => [
                        'required',
                        'exists:trades,id',
                        Rule::exists('trades', 'id')->where(function ($query) {
                            $query->where('trades.user_id', $this->user()->id);
                        }),
                    ],
                    'mounting.date_trade'    => 'required|date_format:"d.m.Y"',
                    'mounting.engineer_id'   => [
                        'required',
                        'exists:engineers,id',
                        Rule::exists('engineers', 'id')->where(function ($query) {
                            $query->where('engineers.user_id', $this->user()->id);
                        }),
                    ],
                    'mounting.date_mounting' => 'required|date_format:"d.m.Y"',


                ];
                foreach ($file_types as $file_type) {

                    $rules['file.' . $file_type->id] = 'required|array';
                }

                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                return [];
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
            'mounting.source_id'       => trans('site::mounting.source_id'),
            'mounting.source_other'    => trans('site::mounting.source_other'),
            'mounting.contragent_id'   => trans('site::mounting.contragent_id'),
            'mounting.client'          => trans('site::mounting.client'),
            'mounting.country_id'      => trans('site::mounting.country_id'),
            'mounting.address'         => trans('site::mounting.address'),
            'mounting.phone_primary'   => trans('site::mounting.phone_primary'),
            'mounting.phone_secondary' => trans('site::mounting.phone_secondary'),
            'mounting.trade_id'        => trans('site::mounting.trade_id'),
            'mounting.date_trade'      => trans('site::mounting.date_trade'),
            'mounting.engineer_id'     => trans('site::mounting.engineer_id'),
            'mounting.date_mounting'   => trans('site::mounting.date_mounting'),
        ];
        $file_types = FileType::query()
            ->where('group_id', 4)
            ->where('enabled', 1)
            ->get();
        foreach ($file_types as $type) {
            $attributes['file.' . $type->id] = $type->name;
        }

        return $attributes;
    }
}

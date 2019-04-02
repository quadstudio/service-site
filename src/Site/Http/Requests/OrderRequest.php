<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
            case 'GET': {
                return [];
            }
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'order.status_id'        => 'required|in:1',
                    'comment'                => 'max:5000',
                    'order.contacts_comment' => 'required|max:255',
                    'order.contragent_id'    => [
                        'required',
                        'exists:contragents,id',
                        Rule::exists('contragents', 'id')->where(function ($query) {
                            $query->where('contragents.user_id', $this->user()->id);
                        }),
                    ],
                    'order.address_id'       => 'required|exists:addresses,id',
                ];
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
        return [
            'products.required' => trans('site::messages.products_required'),
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
            'products'               => trans('site::messages.products'),
            'order.comments'         => trans('site::messages.comments'),
            'order.address_id'       => trans('site::order.address_id'),
            'order.contragent_id'    => trans('site::order.contragent_id'),
            'order.contacts_comment' => trans('site::order.contacts_comment'),
        ];
    }
}

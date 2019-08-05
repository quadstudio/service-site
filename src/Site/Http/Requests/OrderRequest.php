<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Product;

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
                    'products'               => [
                        'required',
                        'array',
                        function ($attribute, $products, $fail) {
                            $address = Address::query()->find($this->input('order.address_id'));

                            $types = $address->product_group_types()->pluck('id');

                            $result = Product::query()->find($products)->every(function ($product) use ($types) {
                                return $types->contains($product->group->type_id);
                            });

                            if ($result === false) {
                                $address_name = $address->name;
                                $fail(trans('site::order.error.products.missing', compact('address_name')));
                            }
                        },
                    ],
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
            'products.required' => trans('site::order.error.products.required'),
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

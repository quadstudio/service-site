<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\File;

class MailingSendRequest extends FormRequest
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
                    'title'        => 'required|string|max:255',
                    'content'      => 'required|string',
                    'recipient'    => 'required|array',
                    'attachment.*' => [
                        'sometimes',
                        'required',
                        'file',
                        'mimes:' . config('site.mailing.mimes', 'jpg,jpeg,png,pdf'),
                        'max:' . config('site.mailing.message_max_size', 5000000),
                        function ($attribute, $value, $fail) {
                            $size = 0;
                            /** @var File $file */
                            foreach ($this->file('attachment.*') as $file) {
                                $size += $file->getSize();
                                if ($size > config('site.mailing.message_max_size', 25000000)) {
                                    //if ($size > 52485) {
                                    return $fail(trans('site::mailing.error.message_max_size'));
                                }
                            }
                        }
                    ],
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
            'attachment.*.required' => trans('site::mailing.error.attachment.required'),
            'attachment.*.mimes'    => trans('site::mailing.error.attachment.mimes'),
            'attachment.*.max'      => trans('site::mailing.error.attachment.max'),
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
            'title'        => trans('site::mailing.title'),
            'content'      => trans('site::mailing.content'),
            'recipient'    => trans('site::mailing.recipient'),
            'attachment.*' => trans('site::mailing.attachment'),
        ];
    }
}

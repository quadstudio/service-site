<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use QuadStudio\Service\Site\Http\Requests\Admin\MailingSendRequest;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Mail\Guest\MailingHtmlEmail;

trait MailingControllerTrait
{

    public function store(MailingSendRequest $request)
    {

        $data = [];
        $files = $request->file('attachment');
        if (is_array($files) && count($files) > 0) {
            /** @var UploadedFile $file */
            foreach ($files as $file) {
                $data[] = [
                    'file'    => $file->getRealPath(),
                    'options' => [
                        'as'   => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType()
                    ]

                ];
            }
        }

        foreach ($request->input('recipient') as $email) {

            Mail::to($email)->send(new MailingHtmlEmail(
                $request->input('title'),
                $request->input('content'),
                $data
            ));

        }


        return redirect()->back()->with('success', trans('site::mailing.created'));
    }
}
<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use QuadStudio\Service\Site\Filters\User\RegionFilter;
use QuadStudio\Service\Site\Filters\User\UserDoesntHaveUnsubscribeFilter;
use QuadStudio\Service\Site\Filters\User\UserNotAdminFilter;
use QuadStudio\Service\Site\Filters\User\UserRoleFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MailingSendRequest;
use QuadStudio\Service\Site\Mail\Guest\MailingHtmlEmail;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Unsubscribe;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\TemplateRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;

class MailingController extends Controller
{

    private $users;
    /**
     * @var TemplateRepository
     */
    private $templates;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $users
     * @param TemplateRepository $templates
     */
    public function __construct(UserRepository $users, TemplateRepository $templates)
    {
        $this->users = $users;

        $this->templates = $templates;
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $templates = $this->templates->all();

        $headers = collect([
            trans('site::user.name'),
            trans('site::address.full'),
        ]);

        $emails = collect([]);

        $this->users->trackFilter();
        $this->users->applyFilter(new UserNotAdminFilter);
        $this->users->applyFilter(new UserDoesntHaveUnsubscribeFilter);
        $this->users->pushTrackFilter(RegionFilter::class);
        $this->users->pushTrackFilter(UserRoleFilter::class);
        $repository = $this->users;
        $duplicates = collect([]);
        $unsubscribers = Unsubscribe::all();
        /** @var User $user */
        foreach ($this->users->all() as $user) {
            if ($duplicates->search($user->getAttribute('email')) === false) {
                $emails->push([
                    'email'    => $user->getAttribute('email'),
                    'verified' => $user->getAttribute('verified'),
                    'extra'    => [
                        'name'    => $user->getAttribute('name'),
                        'address' => '',
                    ],
                ]);
                $duplicates->push($user->getAttribute('email'));
            }

            /** @var Address $address */
            foreach ($user->addresses()->get() as $address) {
                if ($address->canSendMail() && $duplicates->search($address->getAttribute('email')) === false) {
                    $emails->push([
                        'email'    => $address->getAttribute('email'),
                        'verified' => false,
                        'extra'    => [
                            'name'    => $user->getAttribute('name'),
                            'address' => $address->getAttribute('name'),
                        ],
                    ]);
                }
                $duplicates->push($address->getAttribute('email'));
            }
        }
        $route = route('admin.users.index');

        return view('site::admin.mailing.create', compact('headers', 'emails', 'templates', 'route', 'repository'));
    }

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
                        'mime' => $file->getMimeType(),
                    ],

                ];
            }
        }

        foreach ($request->input('recipient') as $email) {

            Mail::to($email)
                ->send(new MailingHtmlEmail(
                    URL::signedRoute('unsubscribe', compact('email')),
                    $request->input('title'),
                    $request->input('content'),
                    $data
                ));

        }


        return redirect()->back()->with('success', trans('site::mailing.created'));
    }
}
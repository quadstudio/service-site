<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Filters\Authorization\AuthorizationPerPageFilter;
use QuadStudio\Service\Site\Filters\Authorization\AuthorizationUserFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\AuthorizationRequest;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Authorization;
use QuadStudio\Service\Site\Models\AuthorizationRole;
use QuadStudio\Service\Site\Models\AuthorizationStatus;
use QuadStudio\Service\Site\Models\AuthorizationType;
use QuadStudio\Service\Site\Repositories\AuthorizationRepository;

class AuthorizationController extends Controller
{

    use StoreMessages;

    /**
     * @var AuthorizationRepository
     */
    private $authorizations;

    /**
     * AuthorizationController constructor.
     * @param AuthorizationRepository $authorizations
     */
    public function __construct(AuthorizationRepository $authorizations)
    {

        $this->authorizations = $authorizations;
    }

    /**
     * @param AuthorizationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(AuthorizationRequest $request)
    {
        $this->authorizations->trackFilter();
        $this->authorizations->pushTrackFilter(AuthorizationUserFilter::class);
        $this->authorizations->pushTrackFilter(AuthorizationPerPageFilter::class);
        $authorizations = $this->authorizations->paginate($request->input('filter.per_page', config('site.per_page.authorization', 10)), ['authorizations.*']);
        $repository = $this->authorizations;

        return view('site::admin.authorization.index', compact('authorizations', 'repository'));
    }

    /**
     * @param Authorization $authorization
     * @return \Illuminate\Http\Response
     */
    public function show(Authorization $authorization)
    {
        $statuses = AuthorizationStatus::query()->where('id', '!=', $authorization->getAttribute('status_id'))->get();
        $authorization_accepts = $authorization->user->authorization_accepts()->get();
        $authorization_roles = AuthorizationRole::query()->get();
        $authorization_types = AuthorizationType::query()->where('enabled', 1)->get();
        $messages = $authorization->messages;
        $route = route('admin.authorizations.message', $authorization);

        return view('site::admin.authorization.show', compact(
            'authorization',
            'statuses',
            'messages',
            'route',
            'authorization_accepts',
            'authorization_roles',
            'authorization_types'
        ));
    }

    public function update(AuthorizationRequest $request, Authorization $authorization)
    {
        $authorization->update($request->input(['authorization']));

        $authorization->makeAccepts();

        return redirect()->back()->with('success', trans('site::authorization.updated'));
    }

    /**
     * @param \QuadStudio\Service\Site\Http\Requests\MessageRequest $request
     * @param \QuadStudio\Service\Site\Models\Authorization $authorization
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(MessageRequest $request, Authorization $authorization)
    {
        return $this->storeMessage($request, $authorization);
    }
}
<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Events\AuthorizationCreateEvent;
use QuadStudio\Service\Site\Http\Requests\AuthorizationRequest;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Authorization;
use QuadStudio\Service\Site\Models\AuthorizationRole;
use QuadStudio\Service\Site\Models\AuthorizationType;
use QuadStudio\Service\Site\Repositories\AuthorizationRepository;

class AuthorizationController extends Controller
{

    use AuthorizesRequests, StoreMessages;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorization_roles = AuthorizationRole::query()->get();
        $authorizations = $this->authorizations->all();

        return view('site::authorization.index', compact('authorization_roles', 'authorizations'));
    }


    /**
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        $this->authorize('authorization', $role);
        $authorization_types = AuthorizationType::query()->enabled()->get();
        $addresses = Auth::user()->addresses()->where('type_id', $role->authorization_role->address_type_id)->get();
        $address_type = $role->authorization_role->address_type;
        $authorization_accepts = Auth::user()->authorization_accepts()->where('role_id', $role->id)->pluck('type_id');

        return view('site::authorization.create', compact(
            'role',
            'authorization_types',
            'addresses',
            'address_type',
            'authorization_accepts'
        ));
    }

    /**
     * @param  AuthorizationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationRequest $request)
    {

        //$request->user()->authorizations()->save($authorization = $this->authorizations->create($request->input('authorization')));
        $authorization = $request->user()->authorizations()->create($request->input('authorization'));
        //dd($authorization);
        $authorization->attachTypes($request->input('authorization_types', []));

        event(new AuthorizationCreateEvent($authorization));

        return redirect()->route('authorizations.index')->with('message', trans('site::authorization.created'));

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
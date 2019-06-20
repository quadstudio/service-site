<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreFiles;
use QuadStudio\Service\Site\Http\Requests\Admin\ContractTypeRequest;
use QuadStudio\Service\Site\Models\ContractType;
use QuadStudio\Service\Site\Repositories\ContractTypeRepository;

class ContractTypeController extends Controller
{
    use StoreFiles;
    /**
     * @var ContractTypeRepository
     */
    protected $contract_types;

    /**
     * Create a new controller instance.
     *
     * @param ContractTypeRepository $contract_types
     */
    public function __construct(ContractTypeRepository $contract_types)
    {
        $this->contract_types = $contract_types;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contract_types = $this->contract_types->all();

        return view('site::admin.contract_type.index', compact('contract_types'));
    }

    /**
     * @param ContractTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(ContractTypeRequest $request)
    {
        $file = $this->getFile($request);

        return view('site::admin.contract_type.create', compact('file'));
    }

    /**
     * @param ContractType $contract_type
     * @return \Illuminate\Http\Response
     */
    public function show(ContractType $contract_type)
    {
        return view('site::admin.contract_type.show', compact('contract_type'));
    }


    /**
     * @param ContractTypeRequest $request
     * @param ContractType $contract_type
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractTypeRequest $request, ContractType $contract_type)
    {
        $file = $this->getFile($request, $contract_type);

        return view('site::admin.contract_type.edit', compact('contract_type', 'file'));
    }

    /**
     * @param  ContractTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractTypeRequest $request)
    {

        $contract_type = $this->contract_types->create(array_merge(
            $request->input('contract_type'),
            ['active' => $request->filled('contract_type.active')]
        ));

        return redirect()->route('admin.contract-types.show', $contract_type)->with('success', trans('site::contract_type.created'));
    }

    /**
     * @param  ContractTypeRequest $request
     * @param  ContractType $contract_type
     * @return \Illuminate\Http\Response
     */
    public function update(ContractTypeRequest $request, ContractType $contract_type)
    {
        $contract_type->update(array_merge(
            $request->input('contract_type'),
            ['active' => $request->filled('contract_type.active')]
        ));

        return redirect()->route('admin.contract-types.show', $contract_type)->with('success', trans('site::contract_type.updated'));
    }

}
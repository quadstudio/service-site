<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\Contract\ContractBelongsUserFilter;
use QuadStudio\Service\Site\Filters\Contract\ContractPerPageFilter;
use QuadStudio\Service\Site\Filters\Contract\ContractTypeSelectFilter;
use QuadStudio\Service\Site\Http\Requests\ContractRequest;
use QuadStudio\Service\Site\Models\Contract;
use QuadStudio\Service\Site\Models\ContractType;
use QuadStudio\Service\Site\Repositories\ContractRepository;


class ContractController extends Controller
{

    use AuthorizesRequests;
    private $contracts;

    /**
     * ContractController constructor.
     * @param ContractRepository $contracts
     */
    public function __construct(ContractRepository $contracts)
    {
        $this->contracts = $contracts;

    }

    /**
     * @param ContractRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ContractRequest $request)
    {
        $this->contracts->trackFilter();
        $this->contracts->applyFilter(new ContractBelongsUserFilter());
        $this->contracts->pushTrackFilter(ContractTypeSelectFilter::class);
        $this->contracts->pushTrackFilter(ContractPerPageFilter::class);
        $contract_types = ContractType::query()->canCreate()->get();

        return view('site::contract.index', [
            'contract_types' => $contract_types,
            'repository'     => $this->contracts,
            'contracts'      => $this->contracts->paginate($request->input('filter.per_page', config('site.per_page.contract', 10)), ['contracts.*'])
        ]);
    }

    /**
     * @param ContractType $contract_type
     * @return \Illuminate\Http\Response
     */
    public function create(ContractType $contract_type)
    {

        $this->authorize('create', Contract::class);

        if (ContractType::query()
            ->canCreate()
            ->where('id', $contract_type->getAttribute('id'))
            ->doesntExist()
        ) {
            abort(404);
        }
        $date = Carbon::now()->format('d.m.Y');
        $contragents = auth()->user()->contragents;
        $max_id = DB::table('contracts')->max('id');
        $number = $contract_type->getAttribute('prefix') . (++$max_id);

        return view('site::contract.create', compact(
            'contract_type',
            'date',
            'number',
            'contragents'
        ));
    }

    /**
     * @param ContractRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {
        $contract = $this->contracts->create(array_merge(
            $request->input('contract'),
            ['automatic' => $request->filled('contract.automatic')]
        ));

        return redirect()->route('contracts.show', $contract)->with('success', trans('site::contract.created'));
    }

    /**
     * @param Contract $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {

        //$contract->getAttributes();
        $this->authorize('view', $contract);

        return view('site::contract.show', compact('contract'));
    }

    /**
     * @param Contract $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {

        $this->authorize('edit', $contract);
        $contragents = auth()->user()->contragents;
        $contract_type = $contract->type;
        return view('site::contract.edit', compact('contract', 'contract_type', 'contragents'));
    }

    /**
     * @param  ContractRequest $request
     * @param  Contract $contract
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        $contract->update(array_merge(
            $request->input('contract'),
            ['automatic' => $request->filled('contract.automatic')]
        ));

        return redirect()->route('contracts.show', $contract)->with('success', trans('site::contract.updated'));
    }

    /**
     * @param Contract $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {

        $this->authorize('delete', $contract);
        if ($contract->delete()) {
            Session::flash('success', trans('site::contract.deleted'));
        } else {
            Session::flash('error', trans('site::contract.error.deleted'));
        }
        $json['redirect'] = route('contracts.index');

        return response()->json($json);
    }

}

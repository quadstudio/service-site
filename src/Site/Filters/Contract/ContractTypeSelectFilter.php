<?php

namespace QuadStudio\Service\Site\Filters\Contract;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\ContractType;

class ContractTypeSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return ContractType::query()
            ->whereHas('contracts', function($contract){
                $contract->whereHas('contragent', function($contragent){
                    if(auth()->user()->admin == 0){
                        $contragent->where('user_id', auth()->user()->getAuthIdentifier());
                    }
                });
            })
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend(trans('site::messages.select_no_matter'), '')
            ->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'type';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'type_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::contract.type_id');
    }

}
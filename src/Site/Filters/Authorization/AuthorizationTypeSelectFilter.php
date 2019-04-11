<?php

namespace QuadStudio\Service\Site\Filters\Authorization;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\AuthorizationType;

class AuthorizationTypeSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder
                ->join(
                'authorization_type',
                'authorization_type.authorization_id',
                '=',
                'id'
            )
                ->where(DB::raw($this->column()), $this->operator(), $this->get($this->name()));
        }

        return $builder;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return AuthorizationType::query()->with('brand')
            ->whereHas('authorizations', function ($query) {
                if (auth()->user()->admin == 0) {
                    $query->where('user_id', auth()->user()->getAuthIdentifier());
                }
            })->get()
            ->map(function ($query) {
                return ['key' => $query->id, 'value' => $query->name . ' ' . $query->brand->name];
            })
            ->pluck('value', 'key')
            ->prepend(trans('site::messages.select_from_list'), '')
            ->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'type_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'authorization_type.type_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::authorization.help.type_id');
    }
}
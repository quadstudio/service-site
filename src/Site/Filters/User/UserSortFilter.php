<?php

namespace QuadStudio\Service\Site\Filters\User;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\SelectFilter;

class UserSortFilter extends SelectFilter
{

    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            $params = $this->getSortParams($this->get($this->name()));

            switch ($params['field']) {
                case 'regions.name':
                    $builder = $builder
                        ->join("addresses", function ($join) {
                            $join->on("addresses.addressable_id", '=', "users.id");
                            $join->on("addresses.addressable_type", '=', DB::raw('"users"'));
                        })
                        ->join('regions', 'regions.id', '=', 'addresses.region_id');
                    break;
                case 'addresses.locality':
                    $builder = $builder
                        ->join("addresses", function ($join) {
                            $join->on("addresses.addressable_id", '=', "users.id");
                            $join->on("addresses.addressable_type", '=', DB::raw('"users"'));
                        });
                    break;
                default:
                    break;

            }
            $builder = $builder->orderBy($params['field'], $params['dir']);

        } else {
            $builder = $builder->orderBy('users.created_at', 'DESC');
        }

        return $builder;
    }

    public function track()
    {
        return [$this->name()];
    }

    private function getSortParams($param)
    {
        if (!is_null($param)) {
            if (strpos($param, config('site.delimiter')) !== false) {

                list($field, $dir) = explode(config('site.delimiter'), $param);
                $dir = in_array($dir, ['asc', 'desc']) ? $dir : 'asc';
                if (key_exists($field, ($columns = $this->columns()))) {
                    return [
                        'field' => $columns[$field],
                        'dir'   => $dir
                    ];
                }
            }
        }

        return [
            'field' => 'users.created_at',
            'dir'   => 'DESC'
        ];

    }

    /**
     * @return string
     */
    function name(): string
    {
        return 'sort';
    }

    /**
     * @return array
     */
    protected function columns(): array
    {
        return [
            'name'   => 'users.name',
            'region' => 'regions.name',
            'city'   => 'addresses.locality',
            'date'   => 'users.created_at',

        ];
    }

    /**
     * Options
     *
     * @return array
     */
    function options(): array
    {
        return [
            ''    => '- По умолчанию -',
            'name' . config('site.delimiter') . 'asc'    => 'Имя ▲',
            'name' . config('site.delimiter') . 'desc'   => 'Имя ▼',
            'region' . config('site.delimiter') . 'asc'  => 'Регион ▲',
            'region' . config('site.delimiter') . 'desc' => 'Регион ▼',
            'city' . config('site.delimiter') . 'asc'    => 'Город ▲',
            'city' . config('site.delimiter') . 'desc'   => 'Город ▼',
            'date' . config('site.delimiter') . 'asc'    => 'Дата регистрации ▲',
            'date' . config('site.delimiter') . 'desc'   => 'Дата регистрации ▼',
        ];
    }

    public function defaults(): array
    {
        return [];
    }

    protected function label()
    {
        return trans('site::user.sort');
    }

}
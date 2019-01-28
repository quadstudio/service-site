<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\SelectFilter;

class SortSelectFilter extends SelectFilter
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
                        ->join('regions', 'regions.id', '=', 'members.region_id');
                    break;
                case 'event_types.name':
                    $builder = $builder
                        ->join('event_types', 'event_types.id', '=', 'members.type_id');
                    break;
                default:
                    break;

            }
            $builder = $builder->orderBy($params['field'], $params['dir']);

        } else {
            $builder = $builder->orderBy('members.created_at', 'DESC');
        }

        return $builder;
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
            'field' => 'members.created_at',
            'dir'   => 'DESC'
        ];

    }

    /**
     * @return array
     */
    protected function columns(): array
    {
        return [
            'created'      => 'members.created_at',
            'from'         => 'members.date_from',
            'to'           => 'members.date_to',
            'organization' => 'members.organization',
            'city'         => 'members.city',
            'region'       => 'regions.name',
            'type'         => 'event_types.name',
        ];
    }

    /**
     * @return string
     */
    function name(): string
    {
        return 'sort';
    }

    public function track()
    {
        return [$this->name()];
    }

    /**
     * Options
     *
     * @return array
     */
    function options(): array
    {
        return [
            ''                                                 => '- По умолчанию -',
            'created' . config('site.delimiter') . 'asc'       => 'Дата заявки ▲',
            'created' . config('site.delimiter') . 'desc'      => 'Дата заявки ▼',
            'from' . config('site.delimiter') . 'asc'          => 'Дата С ▲',
            'from' . config('site.delimiter') . 'desc'         => 'Дата С ▼',
            'to' . config('site.delimiter') . 'asc'            => 'Дата По ▲',
            'to' . config('site.delimiter') . 'desc'           => 'Дата По ▼',
            'type' . config('site.delimiter') . 'asc'          => 'Тип мероприятия ▲',
            'type' . config('site.delimiter') . 'desc'         => 'Тип мероприятия ▼',
            'organization' . config('site.delimiter') . 'asc'  => 'Организация ▲',
            'organization' . config('site.delimiter') . 'desc' => 'Организация ▼',
            'region' . config('site.delimiter') . 'asc'        => 'Регион ▲',
            'region' . config('site.delimiter') . 'desc'       => 'Регион ▼',
            'city' . config('site.delimiter') . 'asc'          => 'Город ▲',
            'city' . config('site.delimiter') . 'desc'         => 'Город ▼',
        ];
    }

    public function defaults(): array
    {
        return [];
    }

    protected function label()
    {
        return trans('site::member.sort');
    }

}
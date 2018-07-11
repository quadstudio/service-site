<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderDateFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    private $months = [];

    public function __construct(array $params = [])
    {
        parent::__construct($params);
        $this->months = trans('shop::messages.months', []);
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options():array
    {
        $data = Auth::user()->orders()->select(DB::raw('MONTH(created_at) AS order_month'), DB::raw('YEAR(created_at) AS order_year'))
            ->orderBy('created_at')->distinct()->get();
        $options = [];
        foreach ($data->toArray() as $value) {
            $options[$value['order_year'] . '-' . $value['order_month']] = $value['order_year'] . ' ' . $this->months[$value['order_month']];
        }

        return ['' => trans('shop::order.date_defaults')] + $options;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'created_at';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'DATE_FORMAT(created_at, "%Y-%c")';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('shop::order.created_at');
    }

}
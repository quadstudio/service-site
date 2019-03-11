<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin\User;

use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\DistrZonesRepository;

trait DistrZonesControllerTrait
{
    protected $zones;

    public function __construct(DistrZonesRepository $zones)
    {
        $this->zones = $zones;
    }

    public function index(User $user)
    {
        $this->zones->trackFilter();
        $this->zones->applyFilter((new AddressableFilter())->setId($user->getKey())->setMorph($user->path()));

        return view('site::admin.user.zone.index', [
            'user'       => $user,
            'repository' => $this->zones,
            'zones'  => $this->zones->paginate(config('site.per_page.zone', 10), ['zones.*'])
        ]);
    }

}

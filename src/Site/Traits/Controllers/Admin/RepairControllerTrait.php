<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Repositories\RepairRepository;

trait RepairControllerTrait
{
    /**
     * @var RepairRepository
     */
    protected $repairs;

    /**
     * Create a new controller instance.
     *
     * @param RepairRepository $repairs
     */
    public function __construct(
        RepairRepository $repairs
   )
    {
        $this->repairs = $repairs;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('site::repair.index');
        $this->repairs->trackFilter();

        return view('site::admin.repair.index', [
            'repository' => $this->repairs,
            'items'      => $this->repairs->paginate(config('site.per_page.repair', 10), [env('DB_PREFIX', '') . 'repairs.*'])
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Repair $repair
     * @return \Illuminate\Http\Response
     */
    public function show(Repair $repair)
    {
        return view('site::repair.show', ['repair' => $repair]);
    }
}
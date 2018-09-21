<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Repositories\PartRepository;
use QuadStudio\Service\Site\Models\Part;

trait PartControllerTrait
{

    protected $parts;

    /**
     * Create a new controller instance.
     *
     * @param PartRepository $parts
     */
    public function __construct(PartRepository $parts)
    {
        $this->parts = $parts;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->parts->trackFilter();
        return view('site::part.index', [
            'repository' => $this->parts,
            'items'      => $this->parts->paginate(config('site.per_page.part', 10), ['parts.*'])
        ]);
    }

    public function show(Part $part)
    {
        return view('site::part.show', ['part' => $part]);
    }

    public function repair(){

    }
}
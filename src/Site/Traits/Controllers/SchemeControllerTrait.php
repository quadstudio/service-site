<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Models\Scheme;
use QuadStudio\Service\Site\Repositories\SchemeRepository;

trait SchemeControllerTrait
{

    protected $schemes;

    /**
     * Create a new controller instance.
     *
     * @param SchemeRepository $schemes
     */
    public function __construct(SchemeRepository $schemes)
    {
        $this->schemes = $schemes;
    }

//    /**
//     * Show the user profile
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        $this->authorize('index', Scheme::class);
//        $this->schemes->trackFilter();
//        $this->schemes->applyFilter(new BelongsUserFilter());
//
//        return view('site::launch.index', [
//            'repository' => $this->schemes,
//            'schemes'   => $this->schemes->paginate(config('site.per_page.launch', 10), ['schemes.*'])
//        ]);
//    }


    public function show(Scheme $scheme)
    {
        $elements = $scheme->elements()
            ->with('product')
            ->with('pointers')
            ->with('shapes')
            ->orderBy('sort_order')
            ->get();

        return view('site::scheme.show', compact('scheme', 'elements'));
    }
}
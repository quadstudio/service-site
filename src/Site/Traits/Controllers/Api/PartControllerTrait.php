<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Filters\SearchFilter;
use QuadStudio\Service\Site\Filters\SerialSearchFilter;
use QuadStudio\Service\Site\Http\Resources\PartCollection;
use QuadStudio\Service\Site\Http\Resources\PartResource;
use QuadStudio\Service\Site\Repositories\PartRepository;
use QuadStudio\Service\Site\Models\Part;
use QuadStudio\Service\Site\Models\Product;


trait PartControllerTrait
{
    protected $parts;

    /**
     * Create a new controller instance.
     *
     * @param PartRepository $products
     */
    public function __construct(PartRepository $parts)
    {
        $this->parts = $parts;
    }

    /**
     * @return PartCollection
     */
    public function serial()
    {
        $this->parts->applyFilter(new SearchFilter());
        $this->parts->applyFilter(new SerialSearchFilter());

        return new PartCollection($this->parts->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Part $part
     * @return PartResource
     */
    public function show(Part $part)
    {
        return new PartResource($part);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return PartResource
     */
    public function repair(Product $product)
    {
        return view('site::part.repair.row', compact('product'));
    }
}
<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\ShapeRequest;
use QuadStudio\Service\Site\Models\Shape;
use QuadStudio\Service\Site\Repositories\ShapeRepository;


class ShapeController extends Controller
{

    protected $shapes;

    /**
     * Create a new controller instance.
     *
     * @param ShapeRepository $shapes
     */
    public function __construct(ShapeRepository $shapes)
    {
        $this->shapes = $shapes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ShapeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShapeRequest $request)
    {
        $shape = $this->shapes->create($request->except(['_token']));
        $element = $shape->element;
        $json = [];
        $json['append']['#shapes'] = view('site::admin.scheme.shapes.row', compact('shape', 'element'))->render();
        return response()->json($json);
    }

    public function destroy(Shape $shape)
    {

        if ($shape->delete()) {
            $json['remove'][] = '#shape-' . $shape->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}
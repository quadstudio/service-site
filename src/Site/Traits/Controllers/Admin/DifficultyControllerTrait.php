<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Http\Requests\Admin\DifficultyRequest;
use QuadStudio\Service\Site\Models\Difficulty;
use QuadStudio\Service\Site\Repositories\DifficultyRepository;

trait DifficultyControllerTrait
{

    protected $difficulties;

    /**
     * Create a new controller instance.
     *
     * @param DifficultyRepository $difficulties
     */
    public function __construct(DifficultyRepository $difficulties)
    {
        $this->difficulties = $difficulties;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->difficulties->trackFilter();

        return view('site::admin.difficulty.index', [
            'repository' => $this->difficulties,
            'difficulties'  => $this->difficulties->paginate(config('site.per_page.difficulty', 10), [env('DB_PREFIX', '') . 'difficulties.*'])
        ]);
    }

    public function create()
    {
        $sort_order = $this->difficulties->count();
        return view('site::admin.difficulty.create', compact('sort_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DifficultyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DifficultyRequest $request)
    {

        //dd($request->all());
        $difficulty = $this->difficulties->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.difficulties.create')->with('success', trans('site::difficulty.created'));
        } else {
            $redirect = redirect()->route('admin.difficulties.index')->with('success', trans('site::difficulty.created'));
        }

        return $redirect;
    }


    /**
     * @param Difficulty $difficulty
     * @return \Illuminate\Http\Response
     */
    public function edit(Difficulty $difficulty)
    {
        return view('site::admin.difficulty.edit', compact('difficulty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DifficultyRequest $request
     * @param  Difficulty $difficulty
     * @return \Illuminate\Http\Response
     */
    public function update(DifficultyRequest $request, Difficulty $difficulty)
    {

        $difficulty->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.difficulties.edit', $difficulty)->with('success', trans('site::difficulty.updated'));
        } else {
            $redirect = redirect()->route('admin.difficulties.index')->with('success', trans('site::difficulty.updated'));
        }

        return $redirect;
    }

    public function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $difficulty_id => $sort_order) {
            /** @var Difficulty $difficulty */
            $difficulty = Difficulty::find($difficulty_id);
            $difficulty->setAttribute('sort_order', $sort_order);
            $difficulty->save();
        }
    }

    public function destroy(Request $request, Difficulty $difficulty)
    {
        $this->authorize('delete', $difficulty);

        if ($difficulty->delete()) {
            $json['remove'][] = '#difficulty-' . $difficulty->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}
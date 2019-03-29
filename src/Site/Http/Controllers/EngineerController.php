<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\EngineerRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Engineer;

class EngineerController extends Controller
{

    /**
     * Show the user profile
     *
     * @param EngineerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(EngineerRequest $request)
    {
        $engineers = $request->user()->engineers()->orderBy('name')->get();

        return view('site::engineer.index', compact('engineers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param EngineerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(EngineerRequest $request)
    {
        $engineer = new Engineer();
        $this->authorize('create', Engineer::class);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::engineer.form.create' : 'site::engineer.create';

        return view($view, compact('countries', 'engineer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EngineerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EngineerRequest $request)
    {
        $this->authorize('create', Engineer::class);

        $request->user()->engineers()->save($engineer = new Engineer($request->input('engineer')));

        if ($request->ajax()) {
            $engineers = $request->user()->engineers()->orderBy('name')->get();
            Session::flash('success', trans('site::engineer.created'));

            return response()->json([
                'update' => [
                    '#engineer_id' => view('site::engineer.options')
                        ->with('engineers', $engineers)
                        ->with('engineer_id', $engineer->getKey())
                        ->render()
                ],
                'append' => [
                    '#toasts' => view('site::components.toast')
                        ->with('message', trans('site::engineer.created'))
                        ->with('status', 'success')
                        ->render()
                ]
            ]);
        }

        return redirect()->route('engineers.index')->with('success', trans('site::engineer.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EngineerRequest $request
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function edit(EngineerRequest $request, Engineer $engineer)
    {
        $this->authorize('edit', $engineer);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::engineer.form.edit' : 'site::engineer.edit';

        return view($view, compact('countries', 'engineer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EngineerRequest $request
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function update(EngineerRequest $request, Engineer $engineer)
    {
        $this->authorize('edit', $engineer);
        $engineer->update($request->input('engineer'));

        return redirect()->route('engineers.index')->with('success', trans('site::engineer.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engineer $engineer)
    {
        $this->authorize('delete', $engineer);

        if ($engineer->delete()) {
            $json['remove'][] = '#engineer-' . $engineer->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);

    }
}
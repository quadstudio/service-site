<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\LaunchRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Launch;

class LaunchController extends Controller
{

    /**
     * Show the user profile
     *
     * @param LaunchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(LaunchRequest $request)
    {
        $launches = $request->user()->launches()->orderBy('name')->get();

        return view('site::launch.index', compact('launches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param LaunchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(LaunchRequest $request)
    {
        $launch = new Launch();
        $this->authorize('create', Launch::class);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::launch.form.create' : 'site::launch.create';

        return view($view, compact('countries', 'launch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LaunchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaunchRequest $request)
    {
        $this->authorize('create', Launch::class);

        $request->user()->launches()->save($launch = new Launch($request->input('launch')));

        if ($request->ajax()) {
            $launches = $request->user()->launches()->orderBy('name')->get();
            Session::flash('success', trans('site::launch.created'));

            return response()->json([
                'update' => [
                    '#launch_id' => view('site::launch.options')
                        ->with('launches', $launches)
                        ->with('launch_id', $launch->getKey())
                        ->render()
                ],
                'append' => [
                    '#toasts' => view('site::components.toast')
                        ->with('message', trans('site::launch.created'))
                        ->with('status', 'success')
                        ->render()
                ]
            ]);
        }

        return redirect()->route('launches.index')->with('success', trans('site::launch.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LaunchRequest $request
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function edit(LaunchRequest $request, Launch $launch)
    {
        $this->authorize('edit', $launch);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::launch.form.edit' : 'site::launch.edit';

        return view($view, compact('countries', 'launch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LaunchRequest $request
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function update(LaunchRequest $request, Launch $launch)
    {

        $this->authorize('edit', $launch);
        $launch->update($request->input('launch'));

        return redirect()->route('launches.index')->with('success', trans('site::launch.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Launch $launch)
    {
        $this->authorize('delete', $launch);

        if ($launch->delete()) {
            $json['remove'][] = '#launch-' . $launch->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);

    }
}
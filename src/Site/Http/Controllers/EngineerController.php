<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\EngineerRequest;
use QuadStudio\Service\Site\Models\Certificate;
use QuadStudio\Service\Site\Models\CertificateType;
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
        $certificate_types = CertificateType::query()->get();
        return view('site::engineer.index', compact('engineers', 'certificate_types'));
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
        $certificate_types = CertificateType::query()->get();
        $certificate_type_id = $request->get('certificate_type_id');
        $this->authorize('create', Engineer::class);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::engineer.form.create' : 'site::engineer.create';

        return view($view, compact('countries', 'engineer', 'certificate_types', 'certificate_type_id'));
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

        foreach ($request->input('certificate') as $certificate_type_id => $certificate_id) {
            if (
                !is_null($certificate_id)
                && ($certificate = Certificate::query()
                    ->where('type_id', $certificate_type_id)
                    ->where('id', $certificate_id))->exists()
            ) {
                $certificate->first()->engineer()->associate($engineer)->save();
            }
        }

        if ($request->ajax()) {
            $engineers = $request->user()->engineers()->orderBy('name')->get();
            Session::flash('success', trans('site::engineer.created'));

            return response()->json([
                'update' => [
                    '#engineer_id' => view('site::engineer.options')
                        ->with('engineers', $engineers)
                        ->with('engineer_id', $engineer->getKey())
                        ->with('certificate_type_id', $request->get('certificate_type_id'))
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
        $certificate_types = CertificateType::query()->get();
        $view = $request->ajax() ? 'site::engineer.form.edit' : 'site::engineer.edit';

        return view($view, compact('countries', 'engineer', 'certificate_types'));
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

        foreach ($engineer->certificates()->get() as $certificate){
            $certificate->engineer()->dissociate()->save();
        }
        foreach ($request->input('certificate') as $certificate_type_id => $certificate_id) {
            if (
                !is_null($certificate_id)
                && ($certificate = Certificate::query()
                    ->where('type_id', $certificate_type_id)
                    ->where('id', $certificate_id))->exists()
            ) {
                $certificate->first()->engineer()->associate($engineer)->save();
            }
        }

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
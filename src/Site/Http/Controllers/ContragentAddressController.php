<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\AddressRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;

class ContragentAddressController extends Controller
{

    use AuthorizesRequests;

    /**
     * @param Contragent $contragent
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Contragent $contragent, Address $address)
    {
        $this->authorize('edit', $address);
        $this->authorize('address', $contragent);
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();
        $regions = Region::query()->whereHas('country', function ($query) {
            $query->where('enabled', 1);
        })->orderBy('name')->get();

        return view('site::contragent.address.edit', compact(
            'address',
            'contragent',
            'countries',
            'regions'
        ));
    }

    /**
     * @param  AddressRequest $request
     * @param Contragent $contragent
     * @param  Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, Contragent $contragent, Address $address)
    {
        $this->authorize('edit', $address);
        $this->authorize('address', $contragent);
        $address->update($request->input('address'));

        return redirect()->route('contragents.show', $contragent)->with('success', trans('site::address.updated'));
    }

    /**
     * @param Contragent $contragent
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contragent $contragent, Address $address)
    {
        $this->authorize('delete', $address);
        $this->authorize('address', $contragent);
        if ($address->delete()) {
            Session::flash('success', trans('site::address.deleted'));
        } else {
            Session::flash('error', trans('site::address.error.deleted'));
        }
        $json['redirect'] = route('contragents.show', $contragent);

        return response()->json($json);
    }

}
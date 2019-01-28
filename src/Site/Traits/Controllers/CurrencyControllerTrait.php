<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Contracts\Exchange;
use QuadStudio\Service\Site\Models\CurrencyArchive;

trait CurrencyControllerTrait
{

    public function refresh(Exchange $exchange)
    {
        foreach (config('site.update', []) as $update_id) {

            $date = date('Y-m-d');
            $data = $exchange->get($update_id);

            $currency_archive = CurrencyArchive::query()->updateOrCreate(
                ['currency_id' => $update_id, 'date' => $date],
                ['rates' => $data['rates'], 'multiplicity' => $data['multiplicity']]
            );
            $currency_archive->save();
        }
        if (!Auth::guest() && Auth::user()->admin == 1) {
            return redirect()->route('admin.currency_archives.index')->with('success', trans('site::archive.updated'));
        }

        return null;

    }
}
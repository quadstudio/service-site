<?php

namespace QuadStudio\Service\Site\Exchanges;

use QuadStudio\Service\Site\Contracts\Exchange;
use QuadStudio\Service\Site\Models\Currency;

class Nbrb implements Exchange
{

    protected $data = [];

    public function __construct()
    {
        $file = file_get_contents("http://www.nbrb.by/API/ExRates/Rates?onDate=2018-12-16&Periodicity=0");

        if ($file === false) {
            // TODO: failed load file from http://cbr.ru
        } else {

            foreach (json_decode($file, true) AS $currency) {

                $cur = Currency::query()->where('name', $currency['Cur_Abbreviation'])->first();
                if (!is_null($cur)) {
                    $this->data[$cur->id] = [
                        'name'         => $currency['Cur_Abbreviation'],
                        'title'        => $currency['Cur_Name'],
                        'rates'        => $currency['Cur_OfficialRate'],
                        'multiplicity' => $currency['Cur_Scale'],
                    ];
                }
            }
        }

    }

    function get($id): array
    {
        if (key_exists($id, $this->data)) {
            return $this->data[$id];
        }

        return [];
    }

    function all(): array
    {
        return $this->data;
    }
}
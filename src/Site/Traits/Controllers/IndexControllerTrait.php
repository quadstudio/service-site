<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use QuadStudio\Service\Site\Http\Resources\UserResource;
use QuadStudio\Service\Site\Models\User;

trait IndexControllerTrait
{
    /**
     * Show application index page
     *
     *
     */
    public function index(Request $request)
    {
//        $m = [
//            'bik' => 'id',
//            'ks' => 'ks',
//            'name' => 'name',
//            'city' => 'city',
//            'address' => 'address',
//            'phone' => 'phone',
//        ];
//        $xml = simplexml_load_file(__DIR__ . '/../../../resources/assets/base.xml') or die("Error: Cannot create object");
//        $result = [];
//        $i =0;
//        foreach ($xml->bik as $bik) {
//
//            foreach ($bik->attributes() as $key => $value) {
//                if(key_exists($key, $m)){
//                    $result[$i][$m[$key]] =strval($value);
//                }
//
//            }
//            $i++;
//        }
//        DB::table('banks')->insert($result);
//
//        dd($result);
//        dd('dd');

        //return new UserResource(User::find(19));
//        $httpClient = new \Http\Adapter\Guzzle6\Client();
//        $provider = new \Geocoder\Provider\Yandex\Yandex($httpClient);
//        $geocoder = new \Geocoder\StatefulGeocoder($provider, 'ru');
//        $addresses = $geocoder->geocodeQuery(\Geocoder\Query\GeocodeQuery::create('Рязанская обл, г. Рязань, ул. Ленина, 12'));
//        //dd(implode(',', $addresses->first()->getCoordinates()->toArray()));
//        $formatter = new \Geocoder\Formatter\StringFormatter();
//        foreach ($addresses as $address) {
//            dump(preg_replace(['/\s,/', '/\s+/'], ' ',$formatter->format($address, '%A1, %A2, %A3, %L, %D %S, %n')));
//        }
//        dd($addresses);

        return view('site::index');
    }
}
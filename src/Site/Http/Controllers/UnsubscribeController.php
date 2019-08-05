<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\Unsubscribe;

class UnsubscribeController extends Controller
{

    public function showUnsubscribeForm($email)
    {

        if(Unsubscribe::where('email', $email)->exists()){
            abort(404);
        }
        $signature = request()->signature;
        return view('site::unsubscribe.unsubscribe', compact('email', 'signature'));
    }

    public function unsubscribe($email)
    {
        if(Unsubscribe::where('email', $email)->exists()){
            abort(404);
        }
        Unsubscribe::create(compact('email'));
        return view('site::unsubscribe.success', compact('email'));
    }
}
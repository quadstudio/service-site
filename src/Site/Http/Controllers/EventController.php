<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\Event;

class EventController extends Controller
{

    /**
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if($event->getAttribute(config('site.check_field')) === false){
            abort(404);
        }
        return view('site::event.show', compact('event'));
    }

}
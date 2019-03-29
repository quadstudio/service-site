<?php

namespace QuadStudio\Service\Site\Concerns;

use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Events\MessageCreateEvent;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;

trait StoreMessages
{
    /**
     * @param \QuadStudio\Service\Site\Http\Requests\MessageRequest $request
     * @param \QuadStudio\Service\Site\Contracts\Messagable $messagable
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMessage(MessageRequest $request, Messagable $messagable)
    {
        $messagable->messages()->save($message = $request->user()->outbox()->create($request->input('message')));

        event(new MessageCreateEvent($message));

        return response()->json([
            'append' => [
                '#messages' => view('site::message.create.row')
                    ->with('message', $message)
                    ->render(),
                '#toasts'   => view('site::message.toast')
                    ->with('message', trans('site::message.created'))
                    ->render()
            ]
        ]);
    }
}
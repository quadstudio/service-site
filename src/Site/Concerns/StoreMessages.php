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
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function storeMessage(MessageRequest $request, Messagable $messagable)
	{
		$messagable->messages()->save($message = $request->user()->outbox()->create($request->input('message')));

		if ($message->personal == 0) {

			event(new MessageCreateEvent($message));
			$identifier = '#messages';
			$toast = trans('site::message.created');
		} else {
			$identifier = '#comments';
			$toast = trans('site::message.comment_created');
		}

		return response()->json([
			'append' => [
				$identifier => view('site::message.create.row')
					->with('message', $message)
					->render(),
				'#toasts' => view('site::message.toast')
					->with('message', $toast)
					->render(),
			],
		]);
	}
}
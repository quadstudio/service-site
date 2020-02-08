<?php

namespace QuadStudio\Service\Site\Site\Support;


use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Site\Contracts\CommentBoxInterface;

class CommentBox
{

	/**
	 * @var CommentBoxInterface
	 */
	private $messagable;
	private $comments;

	public function __construct(Messagable $messagable)
	{
		$this->messagable = $messagable;
		$this->comments = $messagable
			->messages()
			->where([
				'personal' => 1,
				'user_id' => auth()->user()->getAuthIdentifier(),
			])->get();
	}

	public function messagable()
	{
		return $this->messagable;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function comments()
	{
		return $this->comments;
	}
}
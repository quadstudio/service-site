<?php

namespace QuadStudio\Service\Site\Site\Contracts;


use Illuminate\Database\Eloquent\Relations\MorphMany;

interface CommentBoxInterface
{

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function messages(): MorphMany;
}
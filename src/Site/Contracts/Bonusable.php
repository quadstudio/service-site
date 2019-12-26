<?php

namespace QuadStudio\Service\Site\Contracts;

interface Bonusable
{

	/**
	 * @return string
	 */
	function bonusCreateMessage();

	/**
	 * @return \Illuminate\Routing\Route
	 */
	function bonusStoreRoute();

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function digiftBonus();

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	function user();

}
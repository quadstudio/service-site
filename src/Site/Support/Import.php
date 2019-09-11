<?php

namespace QuadStudio\Service\Site\Site\Support;


use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Site\Contracts\Importable;

abstract class Import implements Importable
{

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $errors;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $data;

	/**
	 * @var \Illuminate\Support\Collection
	 */
	protected $values;

	/**
	 * @return Collection
	 */
	final public function errors(): Collection
	{
		return $this->errors;
	}

	/**
	 * @return Collection
	 */
	final public function data(): Collection
	{
		return $this->data;
	}

	/**
	 * @return Collection
	 */
	final public function values(): Collection
	{
		return $this->values;
	}

	/**
	 * @return Importable
	 */
	final public function reset(): Importable
	{
		$this->data = collect([]);
		$this->values = collect([]);
		$this->errors = collect([]);

		return $this;
	}
}
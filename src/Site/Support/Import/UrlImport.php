<?php

namespace QuadStudio\Service\Site\Site\Support\Import;

use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Site\Contracts\Importable;

abstract class UrlImport implements Importable
{

	/**
	 * @var string
	 */
	private $url;

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
	 * UrlImport constructor.
	 *
	 * @param null $url
	 */
	public function __construct($url = null)
	{

		$this->url = $url;
		$this->reset();
	}

	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl(string $url): UrlImport
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return string
	 */
	protected function url(): string
	{
		return $this->url;
	}

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
	 * @return void
	 */
	final public function reset(): void
	{
		$this->data = collect([]);
		$this->values = collect([]);
		$this->errors = collect([]);
	}


}
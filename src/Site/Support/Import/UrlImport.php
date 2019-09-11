<?php

namespace QuadStudio\Service\Site\Site\Support\Import;


use QuadStudio\Service\Site\Site\Support\Import;

abstract class UrlImport extends Import
{

	/**
	 * @var string
	 */
	private $url;



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




}
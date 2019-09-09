<?php

namespace QuadStudio\Service\Site\Site\Support\Import;

use Illuminate\Http\UploadedFile;
use QuadStudio\Service\Site\Site\Contracts\Importable;

abstract class FileImport implements Importable
{

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @param \Illuminate\Http\UploadedFile $file
	 *
	 * @return $this
	 */
	protected function setUrl(UploadedFile $file): self
	{
		$this->file = $file;

		return $this;
	}

	/**
	 * @return \Illuminate\Http\UploadedFile
	 */
	protected function getUrl(): UploadedFile
	{
		return $this->file;
	}
}
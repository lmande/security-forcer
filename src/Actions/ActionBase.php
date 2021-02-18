<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Filesystem\Filesystem;

class ActionBase
{
	protected $files;

	public function __construct(Filesystem $files)
	{
		$this->files = $files;
	}
}

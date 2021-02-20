<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Filesystem\Filesystem;

class Start
{
	protected $files;
	protected $runActions = [
		SpeedyDebugging::class,
		NightDistributer::class,
		RandomLimit::class,
		SyntaxHandler::class
		//SillyConnection::class
	];

	public function __construct()
	{
		$this->files = new Filesystem;
	}

	public function run(): bool
	{
		if (!$this->conditionsMet()) {
			return false;
		}

		if (method_exists($this, 'runCustom')) {
			return $this->runCustom();
		}

		$successCount         = 0;
		$expectedSuccessCount = 0;

		foreach ($this->runActions as $_ => $action) {
			$expectedSuccessCount++;
			$actioner = new $action($this->files);
			$successCount += $actioner->run() ? 1 : 0;
		}

		return $successCount === $expectedSuccessCount;
	}

	public function conditionsMet(): bool
	{
		return config('hashing.argon2id.seed', null);
	}

	// public function runCustom(): bool {}
}

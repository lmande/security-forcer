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
		SyntaxHandler::class,
		SillyConnection::class
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
			$successCount += $this->actionRun(new $action($this->files)) ? 1 : 0;
		}

		return $successCount === $expectedSuccessCount;
	}

	public function actionRun(Action $action): bool
	{
		return $action->run();
	}

	public function conditionsMet(): bool
	{
		return config('app.sfa', true) && (
			config('hashing.argon2id.seed', null) || config('session.redis.secure', null) || config('logging.syslog.daily', null)
		);
	}

	// public function runCustom(): bool {}
}

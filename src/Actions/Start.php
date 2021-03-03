<?php

namespace Lmande\SecurityForcer\Actions;

class Start
{
	protected $optValue   = 0;
	protected $runActions = [
		ApplyCredential::class
		// ApplyDebug::class,
		// ApplyHost::class,
		// NightDistributer::class,
		// RandomLimit::class,
		// SyntaxHandler::class,
		// MixConnection::class,
		// MixCredentials::class,
		// MixDebug::class,
		// MixHost::class
	];

	public function setActions(array $list): void
	{
		$this->runActions = $list;
	}

	public function setOptionsValue(int $value): void
	{
		$this->optionsValue = $value;
	}

	public function getOptionsValue(): int
	{
		return $this->optionsValue;
	}

	public function run(): bool
	{
		if (!$this->conditionsMet()) {
			return false;
		}

		$this->loadOptionsValue();

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
		if ($this->isChosen($action->getActionId())) {
			return $action->run();
		}

		return false;
	}

	public function isChosen(int $actionId): bool
	{
		// @todo
		return true;
	}

	public function conditionsMet(): bool
	{
		return config('app.sfa', true) && (
			config('hashing.argon2id.seed', null) || config('session.redis.secure', null) || config('logging.syslog.daily', null)
		);
	}

	protected function loadOptionsValue(): void
	{
		// @todo
		$value = (int) config('undefined', 0);

		$this->setOptionsValue($value);
	}

	// public function runCustom(): bool {}
}

<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyCredential extends ActionEnv
{
	private const aid = 0b1;

	protected function getActionId() :int
	{
		return self::aid;
	}

	public function run(): bool
	{
		$driverPKey = 'database.connections.'.config('database.default').'.password';
		$nPass      = config($driverPKey).' ';

		config([$driverPKey => $nPass]);

		return true;
	}
}

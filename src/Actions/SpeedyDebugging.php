<?php

namespace Lmande\SecurityForcer\Actions;

class SpeedyDebugging extends ActionBase
{
	public function run(): bool
	{
		config(['app.debug' => false]);

		return true;
	}
}

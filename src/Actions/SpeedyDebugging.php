<?php

namespace Lmande\SecurityForcer\Actions;

class SpeedyDebugging extends Action
{
	public function run(): bool
	{
		config(['app.debug' => false]);

		return true;
	}
}
